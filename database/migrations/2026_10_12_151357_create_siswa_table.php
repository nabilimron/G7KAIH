<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id('id_siswa');
            $table->foreignId('id_user')->constrained('user', 'id_user');
            $table->foreignId('id_guru')->constrained('guru_wali', 'id_guru');
            $table->foreignId('id_kelas')->constrained('kelas', 'id_kelas');
            $table->string('nisn');
            $table->string('nama_siswa');
            $table->enum('jenis_kelamin', ['L', 'P']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};