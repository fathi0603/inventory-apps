<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barang', function (Blueprint $table) {

            $table->string('kode_barang')->after('id_barang');

            $table->integer('stok_minimum')
                  ->default(10)
                  ->after('stok');

            $table->string('lokasi')
                  ->after('tanggal_expired');

        });
    }

    public function down(): void
    {
        Schema::table('barang', function (Blueprint $table) {

            $table->dropColumn([
                'kode_barang',
                'stok_minimum',
                'lokasi'
            ]);

        });
    }
};