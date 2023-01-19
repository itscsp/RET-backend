<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create([
            'name' => 'chethan',
            'email' => 'chethan@gmail.com',
            'password' => 'chethan',
            'role' => 'admin'
        ]);
    }
}
