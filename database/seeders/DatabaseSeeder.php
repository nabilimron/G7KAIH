<?php

namespace Database\Seeders;

use App\Models\Badge;
use App\Models\GuruWali;
use App\Models\Kebiasaan;
use App\Models\Kelas;
use App\Models\Semester;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // 1. Kosongkan seluruh riwayat laporan & pencapaian badge
        Schema::disableForeignKeyConstraints();
        DB::table('detail_laporan')->truncate();
        DB::table('laporan')->truncate();
        DB::table('badge_siswa')->truncate();
        DB::table('siswa')->truncate();
        DB::table('guru_wali')->truncate();
        DB::table('admin')->truncate();
        DB::table('user')->truncate();
        DB::table('users')->truncate();
        Schema::enableForeignKeyConstraints();

        // 2. 7 Kebiasaan Anak Indonesia Hebat
        Kebiasaan::where('nama_kebiasaan', 'Makan Sehat dan Bergizi')
            ->update(['nama_kebiasaan' => 'Makan Sehat & Bergizi']);
        $kebiasaanList = [
            ['nama_kebiasaan' => 'Bangun Pagi', 'deskripsi' => 'Bangun lebih awal sebelum subuh dan merapikan tempat tidur.'],
            ['nama_kebiasaan' => 'Beribadah', 'deskripsi' => 'Melaksanakan ibadah sesuai keyakinan tepat waktu.'],
            ['nama_kebiasaan' => 'Berolahraga', 'deskripsi' => 'Melakukan aktivitas fisik atau olahraga minimal 15-30 menit.'],
            ['nama_kebiasaan' => 'Makan Sehat & Bergizi', 'deskripsi' => 'Mengonsumsi makanan bergizi seimbang serta air putih cukup.'],
            ['nama_kebiasaan' => 'Gemar Belajar', 'deskripsi' => 'Membaca buku atau mengulang materi pelajaran di rumah.'],
            ['nama_kebiasaan' => 'Bermasyarakat', 'deskripsi' => 'Membantu orang tua, bertutur sopan, dan peduli lingkungan.'],
            ['nama_kebiasaan' => 'Tidur Cepat', 'deskripsi' => 'Beristirahat malam tepat waktu agar tubuh bugar esok hari.'],
        ];
        foreach ($kebiasaanList as $item) {
            Kebiasaan::firstOrCreate(['nama_kebiasaan' => $item['nama_kebiasaan']], $item);
        }

        // 3. Semester aktif & Kelas
        Semester::firstOrCreate(
            ['tahun_ajaran' => '2026/2027', 'nama_semester' => 'Ganjil'],
            ['tanggal_mulai' => '2026-07-13', 'tanggal_selesai' => '2026-12-19']
        );

        $kelas9B = Kelas::firstOrCreate(['nama_kelas' => 'IX B']);
        Kelas::firstOrCreate(['nama_kelas' => 'IX A']);
        Kelas::firstOrCreate(['nama_kelas' => 'VIII A']);

        // 4. Master Badge Pencapaian (kosong belum diraih siswa)
        $badges = [
            ['nama' => 'Pejuang Pagi', 'deskripsi' => 'Bangun pagi tepat waktu.', 'syarat' => '1 hari laporan'],
            ['nama' => 'Bintang Ibadah', 'deskripsi' => 'Menjaga kedisiplinan ibadah harian.', 'syarat' => '3 hari laporan'],
            ['nama' => 'Pelajar Aktif', 'deskripsi' => 'Mengisi laporan harian secara rutin.', 'syarat' => '5 hari laporan'],
            ['nama' => 'Konsisten 7 Hari', 'deskripsi' => 'Mengisi laporan 7 hari penuh dalam satu pekan.', 'syarat' => '7 hari laporan'],
            ['nama' => 'Aktif Bergerak', 'deskripsi' => 'Olahraga secara rutin.', 'syarat' => '10 hari olahraga'],
            ['nama' => 'Generasi Hebat', 'deskripsi' => 'Mencapai 14 laporan terverifikasi oleh guru wali.', 'syarat' => '14 laporan disetujui'],
        ];
        foreach ($badges as $b) {
            Badge::firstOrCreate(['nama' => $b['nama']], $b);
        }

        // 5. Tepat 2 Akun Admin, 1 Akun Guru Wali, 1 Akun Murid (Password: Password123)
        $admin1 = User::create([
            'name'     => 'Admin Sekolah 1',
            'username' => 'admin1',
            'email'    => 'admin1@smpn21sinjai.sch.id',
            'password' => 'Password123',
            'role'     => 'admin',
            'status'   => 'aktif',
        ]);
        $legacyAdmin1Id = DB::table('user')->insertGetId([
            'email'        => 'admin1@smpn21sinjai.sch.id',
            'username'     => 'admin1',
            'password'     => Hash::make('Password123'),
            'role'         => 'admin',
            'tanggal_buat' => $now,
        ]);
        DB::table('admin')->insert([
            'id_user'    => $legacyAdmin1Id,
            'nama_admin' => 'Admin Sekolah 1',
            'no_hp'      => '081100000001',
        ]);

        $admin2 = User::create([
            'name'     => 'Admin Sekolah 2',
            'username' => 'admin2',
            'email'    => 'admin2@smpn21sinjai.sch.id',
            'password' => 'Password123',
            'role'     => 'admin',
            'status'   => 'aktif',
        ]);
        $legacyAdmin2Id = DB::table('user')->insertGetId([
            'email'        => 'admin2@smpn21sinjai.sch.id',
            'username'     => 'admin2',
            'password'     => Hash::make('Password123'),
            'role'         => 'admin',
            'tanggal_buat' => $now,
        ]);
        DB::table('admin')->insert([
            'id_user'    => $legacyAdmin2Id,
            'nama_admin' => 'Admin Sekolah 2',
            'no_hp'      => '081100000002',
        ]);

        $guruUser = User::create([
            'name'     => 'Budi Hartono, S.Pd.',
            'username' => 'guru1',
            'email'    => 'guru1@smpn21sinjai.sch.id',
            'password' => 'Password123',
            'role'     => 'guru_wali',
            'status'   => 'aktif',
        ]);
        $legacyGuruId = DB::table('user')->insertGetId([
            'email'        => 'guru1@smpn21sinjai.sch.id',
            'username'     => 'guru1',
            'password'     => Hash::make('Password123'),
            'role'         => 'guru_wali',
            'tanggal_buat' => $now,
        ]);
        $guru = GuruWali::create([
            'id_user'   => $legacyGuruId,
            'user_id'   => $guruUser->id,
            'nip'       => '198705122014021003',
            'nama_guru' => 'Budi Hartono, S.Pd.',
            'no_hp'     => '081234567890',
        ]);

        $siswaUser = User::create([
            'name'     => 'Akram M',
            'username' => 'siswa1',
            'email'    => 'siswa1@smpn21sinjai.sch.id',
            'password' => 'Password123',
            'role'     => 'siswa',
            'status'   => 'aktif',
        ]);
        $legacySiswaId = DB::table('user')->insertGetId([
            'email'        => 'siswa1@smpn21sinjai.sch.id',
            'username'     => 'siswa1',
            'password'     => Hash::make('Password123'),
            'role'         => 'siswa',
            'tanggal_buat' => $now,
        ]);
        Siswa::create([
            'id_user'       => $legacySiswaId,
            'user_id'       => $siswaUser->id,
            'id_guru'       => $guru->id_guru,
            'id_kelas'      => $kelas9B->id_kelas,
            'nisn'          => '0091234567',
            'nama_siswa'    => 'Akram M',
            'jenis_kelamin' => 'L',
        ]);
    }
}
