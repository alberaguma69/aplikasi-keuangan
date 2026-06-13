<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {

            $table->string('nomor_jurnal')
                  ->nullable()
                  ->after('jadwal_pencairan');

        });
    }

    public function down(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {

            $table->dropColumn('nomor_jurnal');

        });
    }
};

