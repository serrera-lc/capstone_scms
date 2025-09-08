<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // 3 counselors with assigned strands
        $counselors = [
            ['name' => 'Counselor Alice', 'email' => 'alice@school.edu', 'strand' => 'STEM'],
            ['name' => 'Counselor Bob', 'email' => 'bob@school.edu', 'strand' => 'ABM'],
            ['name' => 'Counselor Carol', 'email' => 'carol@school.edu', 'strand' => 'HUMSS'],
        ];

        foreach ($counselors as $counselorData) {
            // Create counselor
            $counselor = User::create([
                'name' => $counselorData['name'],
                'email' => $counselorData['email'],
                'password' => Hash::make('password123'), // default password
                'role' => 'counselor',
                'strand' => $counselorData['strand'],
            ]);

            // Create 100 students for this counselor (50 Grade 11, 50 Grade 12)
            for ($i = 1; $i <= 100; $i++) {
                $gradeLevel = $i <= 50 ? 11 : 12;

                User::create([
                    'name' => $faker->name,
                    'email' => strtolower($faker->unique()->firstName) . $i . '@school.edu',
                    'password' => Hash::make('password123'),
                    'role' => 'student',
                    'grade_level' => $gradeLevel,
                    'strand' => $counselorData['strand'],
                    'counselor_id' => $counselor->id,
                ]);
            }
        }
    }
}
