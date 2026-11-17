<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->foreignId('id_siswa')->constrained('siswa', 'id_siswa');
            $table->foreignId('id_semester')->constrained('semester', 'id_semester');
            $table->boolean('status_verifikasi')->default(false);
            $table->foreignId('id_guru_verifikator')->nullable()->constrained('guru_wali', 'id_guru');
            $table->date('tanggal');
            $table->string('catatan');
            $table->dateTime('waktu_input');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};