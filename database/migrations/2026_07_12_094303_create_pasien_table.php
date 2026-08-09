<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pasien', function (Blueprint $table) {

            $table->increments('id_pasien');

            $table->string('no_medik')->unique();
            $table->string('nama_pasien');
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->string('keterangan_pasien');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pasien');
    }
};