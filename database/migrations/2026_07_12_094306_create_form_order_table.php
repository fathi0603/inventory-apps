<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_order', function (Blueprint $table) {

            $table->increments('id_order');

            $table->date('tanggal_order');

            $table->string('departemen');

            $table->integer('jumlah_item')->default(0);

            $table->unsignedInteger('dibuat_oleh');
            $table->unsignedInteger('dicek_oleh');

            $table->string('alasan');

            $table->enum('status', [
                'diajukan',
                'Disetujui',
                'Ditolak',
                'Diterima'
            ])->default('diajukan');

            $table->foreign('dibuat_oleh')
                ->references('id_petugas')
                ->on('petugas')
                ->onDelete('cascade');

            $table->foreign('dicek_oleh')
                ->references('id_petugas')
                ->on('petugas')
                ->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_order');
    }
};