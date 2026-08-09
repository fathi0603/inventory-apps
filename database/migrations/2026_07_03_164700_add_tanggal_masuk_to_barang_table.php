<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('barang', 'tanggal_masuk')) {
            Schema::table('barang', function (Blueprint $table) {
                $table->date('tanggal_masuk')->nullable()->after('stok');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('barang', 'tanggal_masuk')) {
            Schema::table('barang', function (Blueprint $table) {
                $table->dropColumn('tanggal_masuk');
            });
        }
    }
};