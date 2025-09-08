<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offense;

class OffenseSeeder extends Seeder
{
    public function run(): void
    {
        Offense::create([
            'student_id' => 3,
            'offense' => 'Late to class',
            'remarks' => 'Warned by counselor',
            'date' => now()->subDays(5)->toDateString(),
        ]);
    }
}
