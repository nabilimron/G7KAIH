<?php

use App\Models\Kebiasaan;
use App\Models\Laporan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
});

test('akun dummy tepat 2 admin, 1 guru_wali, 1 siswa dan riwayat kosong awal', function () {
    expect(User::where('role', 'admin')->count())->toBe(2);
    expect(User::where('role', 'guru_wali')->count())->toBe(1);
    expect(User::where('role', 'siswa')->count())->toBe(1);
    expect(Laporan::count())->toBe(0);
});

test('halaman home publik tampil dengan 7 kebiasaan dan mengarah ke login', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('Bersama Wujudkan Generasi Hebat')
        ->assertSee('Bangun Pagi')
        ->assertSee('Kontak & Informasi Sekolah')
        ->assertSee(route('login'));
});

test('halaman login, gagal masuk, lupa sandi, dan login siswa1 ke db_g7kaih', function () {
    $this->get('/login')
        ->assertOk()
        ->assertSee('Selamat Datang');

    $this->get('/lupa-sandi')
        ->assertOk()
        ->assertSee('Ajukan Bantuan');

    $this->from('/login')
        ->post('/login', ['username' => 'siswa1', 'password' => 'Salah123'])
        ->assertRedirect('/login')
        ->assertSessionHas('login_error');

    $this->post('/login', ['username' => 'siswa1', 'password' => 'Password123'])
        ->assertRedirect('/student');

    $this->assertAuthenticated();
});

test('tamu dan role non-siswa tidak bisa mengakses /student', function () {
    $this->get('/student')->assertRedirect('/login');

    $admin = User::where('username', 'admin1')->firstOrFail();
    $this->actingAs($admin)->get('/student')->assertForbidden();
});

test('alur siswa (isi laporan dari kosong) lalu verifikasi oleh guru1 dan pantau di admin1', function () {
    $siswaUser = User::where('username', 'siswa1')->firstOrFail();
    $guruUser = User::where('username', 'guru1')->firstOrFail();
    $adminUser = User::where('username', 'admin1')->firstOrFail();
    $kebiasaan = Kebiasaan::all();
    expect($kebiasaan)->toHaveCount(7);

    // 1. Awal kosong: riwayat belum ada
    $this->actingAs($siswaUser)
        ->get('/student')
        ->assertOk()
        ->assertSee('0/7 hari')
        ->assertSee('Belum ada laporan tersimpan');

    // 2. Siswa mengisi form laporan & simpan permanen
    $payloadKebiasaan = [];
    foreach ($kebiasaan as $idx => $k) {
        if ($idx === 0) {
            $payloadKebiasaan[$k->id_kebiasaan] = ['status' => '1', 'waktu' => '05:10'];
        } elseif ($idx === $kebiasaan->count() - 1) {
            $payloadKebiasaan[$k->id_kebiasaan] = ['status' => '1', 'waktu' => '21:15'];
        } else {
            $payloadKebiasaan[$k->id_kebiasaan] = ['status' => '1'];
        }
    }

    $today = now()->toDateString();
    $this->actingAs($siswaUser)
        ->post('/student/laporan', [
            'tanggal'   => $today,
            'kebiasaan' => $payloadKebiasaan,
        ])
        ->assertRedirect('/student');

    $laporan = Laporan::where('id_siswa', $siswaUser->siswa->id_siswa)->firstOrFail();

    // 3. Guru Wali melihat & menyetujui laporan tersebut
    $this->actingAs($guruUser)->get('/teacher')->assertOk()->assertSee('Dashboard Guru Wali');
    $this->actingAs($guruUser)
        ->post('/teacher/verifikasi/' . $laporan->id_laporan, [
            'keputusan' => 'setujui',
            'catatan'   => 'Bagus, pertahankan!',
        ])
        ->assertRedirect('/teacher/verifikasi');

    expect($laporan->fresh()->status_verifikasi)->toBeTrue();

    // 4. Admin melihat ringkasan di /admin dan kelola akun
    $this->actingAs($adminUser)->get('/admin')->assertOk()->assertSee('Dashboard Admin');
    $this->actingAs($adminUser)->get('/akun')->assertOk()->assertSee('Budi Hartono');
    $this->actingAs($adminUser)->get('/perwalian')->assertOk()->assertSee('Akram M');
});

test('admin crud akun tersinkron ke tabel siswa dan crud badge berjalan', function () {
    $admin = User::where('username', 'admin1')->firstOrFail();

    // Tambah akun siswa baru -> otomatis buat profil Siswa
    $this->actingAs($admin)->post('/akun', [
        'name'     => 'Siti Rahma',
        'username' => 'siswa.rahma',
        'password' => 'Password123',
        'role'     => 'siswa',
        'status'   => 'aktif',
    ])->assertRedirect('/akun?role=siswa');

    $newUser = User::where('username', 'siswa.rahma')->firstOrFail();
    expect($newUser->siswa)->not->toBeNull();
    expect($newUser->siswa->nama_siswa)->toBe('Siti Rahma');

    // Edit akun siswa -> sinkron nama_siswa
    $this->actingAs($admin)->put('/akun/' . $newUser->id, [
        'name'     => 'Siti Rahmawati',
        'username' => 'siswa.rahma',
        'role'     => 'siswa',
        'status'   => 'aktif',
    ])->assertRedirect('/akun?role=siswa');

    expect($newUser->fresh()->siswa->nama_siswa)->toBe('Siti Rahmawati');

    // Hapus akun siswa -> bersih tanpa error FK
    $this->actingAs($admin)->delete('/akun/' . $newUser->id)->assertRedirect('/akun?role=siswa');
    expect(User::where('username', 'siswa.rahma')->exists())->toBeFalse();

    // CRUD Badge: Tambah, Edit, Hapus
    $this->actingAs($admin)->post('/badge', [
        'nama'      => 'Badge Uji',
        'deskripsi' => 'Deskripsi badge uji',
        'syarat'    => '2 hari laporan',
    ])->assertRedirect();

    $badge = \App\Models\Badge::where('nama', 'Badge Uji')->firstOrFail();

    $this->actingAs($admin)->put('/badge/' . $badge->id_badge, [
        'nama'      => 'Badge Uji Edit',
        'deskripsi' => 'Deskripsi edit',
        'syarat'    => '3 hari laporan',
    ])->assertRedirect();
    expect($badge->fresh()->nama)->toBe('Badge Uji Edit');

    $this->actingAs($admin)->delete('/badge/' . $badge->id_badge)->assertRedirect();
    expect(\App\Models\Badge::where('id_badge', $badge->id_badge)->exists())->toBeFalse();
});
