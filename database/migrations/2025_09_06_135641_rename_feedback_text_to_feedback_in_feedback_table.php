<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('feedback', function (Blueprint $table) {
            if (Schema::hasColumn('feedback', 'feedback_text')) {
                // Rename feedback_text → feedback
                $table->renameColumn('feedback_text', 'feedback');
            } elseif (!Schema::hasColumn('feedback', 'feedback')) {
                // If no column exists, create it
                $table->text('feedback')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedback', function (Blueprint $table) {
            if (Schema::hasColumn('feedback', 'feedback')) {
                $table->renameColumn('feedback', 'feedback_text');
            }
        });
    }
};
