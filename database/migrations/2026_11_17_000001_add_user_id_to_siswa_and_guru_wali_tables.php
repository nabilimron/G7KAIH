<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('siswa', 'user_id')) {
            Schema::table('siswa', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->after('id_user')->constrained('users')->nullOnDelete();
            });
        }

        if (! Schema::hasColumn('guru_wali', 'user_id')) {
            Schema::table('guru_wali', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->after('id_user')->constrained('users')->nullOnDelete();
            });
        }

        Schema::table('laporan', function (Blueprint $table) {
            $table->string('catatan')->nullable()->default('')->change();
        });

        Schema::table('detail_laporan', function (Blueprint $table) {
            $table->string('keterangan')->nullable()->default('')->change();
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('siswa', 'user_id')) {
            Schema::table('siswa', function (Blueprint $table) {
                $table->dropConstrainedForeignId('user_id');
            });
        }

        if (Schema::hasColumn('guru_wali', 'user_id')) {
            Schema::table('guru_wali', function (Blueprint $table) {
                $table->dropConstrainedForeignId('user_id');
            });
        }
    }
};
