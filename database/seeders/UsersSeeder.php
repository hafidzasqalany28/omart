<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('12345678'),
            'role_id' => 1, // Admin role
        ]);

        User::create([
            'name' => 'Customer User 1',
            'email' => 'customer1@example.com',
            'password' => bcrypt('12345678'),
            'role_id' => 2, // Customer role
        ]);

        User::create([
            'name' => 'Customer User 2',
            'email' => 'customer2@example.com',
            'password' => bcrypt('12345678'),
            'role_id' => 2, // Customer role
        ]);
    }
}
