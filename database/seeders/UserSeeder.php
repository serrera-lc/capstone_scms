<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@scms.com',
            'password' => Hash::make('elsefallado'), // hashed once
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Counselor Jane',
            'email' => 'counselor@scms.com',
            'password' => Hash::make('counselorpassword'), // hashed once
            'role' => 'counselor',
        ]);

        User::create([
            'name' => 'Student John',
            'email' => 'student@scms.com',
            'password' => Hash::make('studentpassword'), // hashed once
            'role' => 'student',
        ]);
    }
}
