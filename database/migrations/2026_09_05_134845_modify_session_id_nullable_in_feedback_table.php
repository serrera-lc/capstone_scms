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
        $table->renameColumn('feedback_text', 'feedback');
    });
}

public function down()
{
    Schema::table('feedback', function (Blueprint $table) {
        $table->renameColumn('feedback', 'feedback_text');
    });
}

};
