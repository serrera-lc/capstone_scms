<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('strand')->nullable();
            $table->integer('grade_level')->nullable();
            $table->unsignedBigInteger('counselor_id')->nullable();

            $table->foreign('counselor_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['counselor_id']);
            $table->dropColumn(['strand', 'grade_level', 'counselor_id']);
        });
    }
};
