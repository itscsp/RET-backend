<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function register(Request $request)
    {

        // !$user && !Hash::check($fields['senderPassword'], $user->password) && 

        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string|confirmed',
            'role' => 'required|string',
            'senderEmail' => 'required|string',
            'senderPassword' => 'required|string'
        ]);

        $user = User::where('email', $fields['senderEmail'])->first();

        try {


            if (!$user || $user['role'] != 'admin' || !Hash::check($fields['senderPassword'], $user->password)) {

                return response([
                    'message' => 'Unauthenticated'
                ], 401);
            }


            $user = User::create([
                'name' => $fields['name'],
                'email' => $fields['email'],
                'password' => bcrypt($fields['password']),
                'role' => $fields['role']
            ]);

            $token = $user->createToken('myapptoken')->plainTextToken;


            $response = [
                'user' => $user,
                'token' => $token,
            ];

            return response($response, 201);
        } catch (\Exception $e) {
            // Handle the exception
            return response([
                'message' => 'An error occurred during the registration process',
                'res' => $e
            ], 500);
        }
    }


    public function login(Request $request)
    {
        try {
            $fields = $request->validate([

                'email' => 'required|string',
                'password' => 'required|string|',

            ]);

            $user = User::where('email', $fields['email'])->first();

            if (!$user || !Hash::check($fields['password'], $user->password)) {
                return response([
                    'message' => 'Bad Credentials'
                ], 401);
            }

            $token = $user->createToken('myapptoken')->plainTextToken;


            $response = [
                'user' => $user,
                'token' => $token
            ];

            return response($response, 201);
        } catch (\Exception $e) {
            // Handle the exception
            return response([
                'message' => 'An error occurred during the registration process',
                'res' => $e
            ], 500);
        }
    }
}
