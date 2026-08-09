<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('form_order', 'status')) {
            Schema::table('form_order', function (Blueprint $table) {
                $table->string('status')
                      ->default('diajukan')
                      ->after('mengetahui');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('form_order', 'status')) {
            Schema::table('form_order', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};