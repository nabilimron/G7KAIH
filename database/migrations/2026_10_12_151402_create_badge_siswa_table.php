<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('badge_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_siswa')->constrained('siswa', 'id_siswa');
            $table->foreignId('id_badge')->constrained('badge', 'id_badge');
            $table->dateTime('diperoleh_pada');
            $table->unique(['id_siswa', 'id_badge']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('badge_siswa');
    }
};