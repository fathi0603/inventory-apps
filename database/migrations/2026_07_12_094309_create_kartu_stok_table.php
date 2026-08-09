<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kartu_stok', function (Blueprint $table) {

            $table->increments('id_kartu');

            $table->unsignedInteger('id_barang');

            $table->date('tanggal_stok');

            $table->integer('jumlah_barang');

            $table->foreign('id_barang')
                ->references('id_barang')
                ->on('barang')
                ->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kartu_stok');
    }
};