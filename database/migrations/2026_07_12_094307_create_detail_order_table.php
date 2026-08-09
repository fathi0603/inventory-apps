<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_order', function (Blueprint $table) {

            $table->increments('id_detail');

            $table->unsignedInteger('id_order');
            $table->unsignedInteger('id_barang');

            $table->integer('jumlah_order');

            $table->string('keterangan_order')->nullable();

            $table->foreign('id_order')
                ->references('id_order')
                ->on('form_order')
                ->onDelete('cascade');

            $table->foreign('id_barang')
                ->references('id_barang')
                ->on('barang')
                ->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_order');
    }
};