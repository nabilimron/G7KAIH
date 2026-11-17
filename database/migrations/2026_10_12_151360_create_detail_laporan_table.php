<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_laporan', function (Blueprint $table) {
            $table->id('id_detail');
            $table->foreignId('id_laporan')->constrained('laporan', 'id_laporan');
            $table->foreignId('id_kebiasaan')->constrained('kebiasaan', 'id_kebiasaan');
            $table->boolean('status');
            $table->string('keterangan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_laporan');
    }
};