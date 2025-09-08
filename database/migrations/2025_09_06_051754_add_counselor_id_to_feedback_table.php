<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('feedback', function (Blueprint $table) {
        $table->foreignId('counselor_id')->nullable()->constrained('users')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('feedback', function (Blueprint $table) {
        $table->dropColumn('counselor_id');
    });
}

};
