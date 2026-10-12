<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guru_wali', function (Blueprint $table) {
            $table->id('id_guru');
            $table->foreignId('id_user')->constrained('user', 'id_user');
            $table->string('nip');
            $table->string('nama_guru');
            $table->string('no_hp');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guru_wali');
    }
};