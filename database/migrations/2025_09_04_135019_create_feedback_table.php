<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('session_id');
            $table->text('feedback_text');
            $table->tinyInteger('rating')->nullable(); // 1–5 stars
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('session_id')->references('id')->on('counseling_sessions')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
