<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('counselor_id');
            $table->date('date');
            $table->time('time');
            $table->enum('status', ['pending', 'approved', 'cancelled'])->default('pending');
            $table->timestamps();

            // foreign keys
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('counselor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
