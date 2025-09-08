<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        Appointment::create([
            'student_id' => 3, // Student John
            'counselor_id' => 2, // Counselor Jane
            'date' => now()->addDays(2)->toDateString(),
            'time' => '14:00',
            'status' => 'pending',
        ]);
    }
}
