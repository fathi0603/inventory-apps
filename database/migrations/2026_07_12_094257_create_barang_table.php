<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {

            $table->increments('id_barang');

            $table->string('kode_barang')->unique();
            $table->string('nama_barang');
            $table->string('jenis_barang');

            $table->integer('stok')->default(0);
            $table->integer('stok_minimum')->default(100);

            $table->date('tanggal_masuk')->nullable();
            $table->date('tanggal_expired')->nullable();

            $table->string('lokasi')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};