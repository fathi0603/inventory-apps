<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penggunaan_barang', function (Blueprint $table) {

            $table->increments('id_penggunaan');

            $table->unsignedInteger('id_pemeriksaan');
            $table->unsignedInteger('id_barang');

            $table->integer('jumlah_penggunaan');

            $table->foreign('id_pemeriksaan')
                ->references('id_pemeriksaan')
                ->on('pemeriksaan')
                ->onDelete('cascade');

            $table->foreign('id_barang')
                ->references('id_barang')
                ->on('barang')
                ->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penggunaan_barang');
    }
};