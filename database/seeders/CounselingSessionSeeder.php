<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CounselingSession;

class CounselingSessionSeeder extends Seeder
{
    public function run(): void
    {
        CounselingSession::create([
            'student_id' => 3,
            'counselor_id' => 2,
            'concern' => 'Academic Stress',
            'notes' => 'Suggested time management strategies',
            'date' => now()->subDays(3)->toDateString(),
        ]);
    }
}
