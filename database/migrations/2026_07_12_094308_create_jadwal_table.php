<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal', function (Blueprint $table) {

            $table->increments('id_jadwal');

            $table->unsignedInteger('id_petugas');

            $table->string('hari');

            $table->string('shift');

            $table->foreign('id_petugas')
                ->references('id_petugas')
                ->on('petugas')
                ->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};