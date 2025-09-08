<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Feedback;

class FeedbackSeeder extends Seeder
{
    public function run(): void
    {
        Feedback::create([
            'student_id' => 3,
            'session_id' => 1,
            'feedback_text' => 'Very helpful session',
            'rating' => 5,
        ]);
    }
}
