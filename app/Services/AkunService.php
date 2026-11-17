<?php

namespace App\Services;

use App\Models\GuruWali;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AkunService
{
    public function __construct(private string $statusAwal = 'aktif')
    {
        logger('AkunController::__construct dijalankan');
    }

    public function buat(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $data['status'] = $data['status'] ?? $this->statusAwal;

            $user = new User($data);
            $user->save();

            $this->sinkronProfil($user);

            return $user;
        });
    }

    public function perbarui(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data) {
            $user->update($data);
            $this->sinkronProfil($user);

            return $user;
        });
    }

    public function hapus(User $user): void
    {
        DB::transaction(function () use ($user) {
            $siswa = Siswa::where('user_id', $user->id)->first();
            if ($siswa) {
                $lapIds = DB::table('laporan')->where('id_siswa', $siswa->id_siswa)->pluck('id_laporan');
                if ($lapIds->isNotEmpty()) {
                    DB::table('detail_laporan')->whereIn('id_laporan', $lapIds)->delete();
                    DB::table('laporan')->whereIn('id_laporan', $lapIds)->delete();
                }
                DB::table('badge_siswa')->where('id_siswa', $siswa->id_siswa)->delete();
                $legacyId = $siswa->id_user;
                $siswa->delete();
                if ($legacyId) {
                    DB::table('user')->where('id_user', $legacyId)->delete();
                }
            }

            $guru = GuruWali::where('user_id', $user->id)->first();
            if ($guru) {
                $fallback = GuruWali::where('id_guru', '!=', $guru->id_guru)->first();
                if (! $fallback && Siswa::where('id_guru', $guru->id_guru)->exists()) {
                    throw new \RuntimeException('Tidak dapat menghapus satu-satunya Guru Wali yang masih membimbing siswa.');
                }
                if ($fallback) {
                    Siswa::where('id_guru', $guru->id_guru)->update(['id_guru' => $fallback->id_guru]);
                }
                DB::table('laporan')->where('id_guru_verifikator', $guru->id_guru)->update(['id_guru_verifikator' => null]);
                $legacyId = $guru->id_user;
                $guru->delete();
                if ($legacyId) {
                    DB::table('user')->where('id_user', $legacyId)->delete();
                }
            }

            $user->delete();
        });
    }

    private function sinkronProfil(User $user): void
    {
        if (! DB::getSchemaBuilder()->hasTable('siswa') || ! DB::getSchemaBuilder()->hasTable('guru_wali')) {
            return;
        }

        if ($user->role === 'guru_wali') {
            $guru = GuruWali::where('user_id', $user->id)->first();
            if ($guru) {
                $guru->update(['nama_guru' => $user->name]);
                return;
            }

            $legacyId = DB::table('user')->insertGetId([
                'email'        => $user->email ?: ($user->username . '@smpn21sinjai.sch.id'),
                'username'     => $user->username,
                'password'     => $user->password ?? Hash::make('Password123'),
                'role'         => 'guru_wali',
                'tanggal_buat' => now(),
            ]);

            GuruWali::create([
                'id_user'   => $legacyId,
                'user_id'   => $user->id,
                'nip'       => '1987' . str_pad((string) $user->id, 14, '0', STR_PAD_LEFT),
                'nama_guru' => $user->name,
                'no_hp'     => '08120000' . str_pad((string) $user->id, 4, '0', STR_PAD_LEFT),
            ]);
            return;
        }

        if ($user->role === 'siswa') {
            $siswa = Siswa::where('user_id', $user->id)->first();
            if ($siswa) {
                $siswa->update(['nama_siswa' => $user->name]);
                return;
            }

            $kelas = Kelas::first() ?? Kelas::create(['nama_kelas' => 'IX B']);
            $guru = GuruWali::first();
            if (! $guru) {
                $gLegacy = DB::table('user')->insertGetId([
                    'email'        => 'guru.default@smpn21sinjai.sch.id',
                    'username'     => 'guru.default.' . $user->id,
                    'password'     => Hash::make('Password123'),
                    'role'         => 'guru_wali',
                    'tanggal_buat' => now(),
                ]);
                $guru = GuruWali::create([
                    'id_user'   => $gLegacy,
                    'nip'       => '198705122014021003',
                    'nama_guru' => 'Guru Wali Default',
                    'no_hp'     => '081234567890',
                ]);
            }

            $legacyId = DB::table('user')->insertGetId([
                'email'        => $user->email ?: ($user->username . '@siswa.smpn21sinjai.sch.id'),
                'username'     => $user->username,
                'password'     => $user->password ?? Hash::make('Password123'),
                'role'         => 'siswa',
                'tanggal_buat' => now(),
            ]);

            Siswa::create([
                'id_user'       => $legacyId,
                'user_id'       => $user->id,
                'id_guru'       => $guru->id_guru,
                'id_kelas'      => $kelas->id_kelas,
                'nisn'          => '009' . str_pad((string) $user->id, 7, '0', STR_PAD_LEFT),
                'nama_siswa'    => $user->name,
                'jenis_kelamin' => 'L',
            ]);
        }
    }
}