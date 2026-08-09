<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_order', function (Blueprint $table) {

            $table->integer('jumlah_diterima')
                  ->default(0)
                  ->after('jumlah_order');

        });
    }

    public function down(): void
    {
        Schema::table('detail_order', function (Blueprint $table) {

            $table->dropColumn('jumlah_diterima');

        });
    }
};