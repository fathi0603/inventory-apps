<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemeriksaan', function (Blueprint $table) {

            $table->increments('id_pemeriksaan');

            $table->string('no_lab')->unique();
            $table->string('nama_pemeriksaan');

            $table->unsignedInteger('id_pasien');
            $table->unsignedInteger('id_dokter');
            $table->unsignedInteger('id_jaminan');
            $table->unsignedInteger('id_petugas');

            $table->date('tanggal_pemeriksaan');

            $table->text('keterangan_klinik')->nullable();
            $table->text('hasil_pemeriksaan')->nullable();

            $table->timestamps();

            $table->foreign('id_pasien')
                ->references('id_pasien')
                ->on('pasien')
                ->onDelete('cascade');

            $table->foreign('id_dokter')
                ->references('id_dokter')
                ->on('dokter')
                ->onDelete('cascade');

            $table->foreign('id_jaminan')
                ->references('id_jaminan')
                ->on('jaminan')
                ->onDelete('cascade');

            $table->foreign('id_petugas')
                ->references('id_petugas')
                ->on('petugas')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan');
    }
};