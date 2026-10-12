<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('badge', function (Blueprint $table) {
            $table->id('id_badge');
            $table->string('nama');
            $table->string('deskripsi');
            $table->string('syarat');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('badge');
    }
};