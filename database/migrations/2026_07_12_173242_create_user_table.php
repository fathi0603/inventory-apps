<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user', function (Blueprint $table) {

            $table->increments('id_user');

            $table->string('username')->unique();
            $table->string('password');
            $table->string('role');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};