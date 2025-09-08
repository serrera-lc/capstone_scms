<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Change ENUM to allow Pending, Approved, Rejected
        DB::statement("ALTER TABLE `appointments` MODIFY `status` ENUM('Pending','Approved','Rejected') NOT NULL DEFAULT 'Pending'");
    }

    public function down(): void
    {
        // Revert ENUM back to original (without Rejected)
        DB::statement("ALTER TABLE `appointments` MODIFY `status` ENUM('Pending','Approved') NOT NULL DEFAULT 'Pending'");
    }
};
