<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\BadgeSiswa;
use App\Models\DetailLaporan;
use App\Models\GuruWali;
use App\Models\Kebiasaan;
use App\Models\Kelas;
use App\Models\Laporan;
use App\Models\Semester;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class StudentController extends Controller
{
    private function currentSiswa(Request $request): Siswa
    {
        $user = $request->user();
        $siswa = Siswa::with(['kelas', 'guruWali'])
            ->where('user_id', $user->id)
            ->first();

        if (! $siswa) {
            $kelas = Kelas::firstOrCreate(['nama_kelas' => 'IX B']);
            $guru = GuruWali::first();
            if (! $guru) {
                $legacyGuruId = DB::table('user')->insertGetId([
                    'email'        => 'guru.default@smpn21sinjai.sch.id',
                    'username'     => 'guru.default',
                    'password'     => Hash::make('Password123'),
                    'role'         => 'guru_wali',
                    'tanggal_buat' => now(),
                ]);
                $guru = GuruWali::create([
                    'id_user'   => $legacyGuruId,
                    'nip'       => '198705122014021003',
                    'nama_guru' => 'Budi Hartono, S.Pd.',
                    'no_hp'     => '081234567890',
                ]);
            }

            $legacyUserId = DB::table('user')->where('username', $user->username ?? $user->email ?? 'siswa' . $user->id)->value('id_user');
            if (! $legacyUserId) {
                $legacyUserId = DB::table('user')->insertGetId([
                    'email'        => $user->email ?? ($user->username . '@siswa.smpn21sinjai.sch.id'),
                    'username'     => $user->username ?? ('siswa' . $user->id),
                    'password'     => $user->password,
                    'role'         => 'siswa',
                    'tanggal_buat' => now(),
                ]);
            }

            $siswa = Siswa::create([
                'id_user'       => $legacyUserId,
                'user_id'       => $user->id,
                'id_guru'       => $guru->id_guru,
                'id_kelas'      => $kelas->id_kelas,
                'nisn'          => str_pad((string) $user->id, 10, '0', STR_PAD_LEFT),
                'nama_siswa'    => $user->name,
                'jenis_kelamin' => 'L',
            ]);
            $siswa->load(['kelas', 'guruWali']);
        }

        return $siswa;
    }

    public function dashboard(Request $request)
    {
        $user = $request->user();
        $siswa = $this->currentSiswa($request);
        $semester = Semester::orderByDesc('id_semester')->first();

        $startOfWeek = now()->startOfWeek(Carbon::MONDAY);
        $endOfWeek = now()->endOfWeek(Carbon::SUNDAY);

        $weeklyReports = Laporan::where('id_siswa', $siswa->id_siswa)
            ->whereBetween('tanggal', [$startOfWeek->toDateString(), $endOfWeek->toDateString()])
            ->get()
            ->keyBy(fn ($l) => $l->tanggal->toDateString());

        $days = [];
        $dayNames = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $rep = $weeklyReports->get($date->toDateString());
            $days[] = [
                'label'  => $dayNames[$i],
                'dayNum' => $date->format('j'),
                'date'   => $date->toDateString(),
                'done'   => $rep !== null,
                'status' => $rep?->statusLabel(),
            ];
        }

        $weekOfMonth = (int) ceil(now()->day / 7);
        $periodeLabel = 'Minggu ke - ' . $weekOfMonth . ' Bulan ' . now()->translatedFormat('F') . ' Tahun ' . now()->year;

        $completedWeekCount = collect($days)->where('done', true)->count();
        $totalLaporan = Laporan::where('id_siswa', $siswa->id_siswa)->count();

        $recentReports = Laporan::with('guruVerifikator')
            ->where('id_siswa', $siswa->id_siswa)
            ->orderByDesc('tanggal')
            ->limit(3)
            ->get();

        $earnedBadges = BadgeSiswa::with('badge')
            ->where('id_siswa', $siswa->id_siswa)
            ->orderByDesc('diperoleh_pada')
            ->get();

        $earnedBadgeIds = $earnedBadges->pluck('id_badge')->all();
        $nextBadge = Badge::whereNotIn('id_badge', $earnedBadgeIds)->first();
        $nextBadgeTarget = 1;
        if ($nextBadge && preg_match('/(\d+)/', (string) $nextBadge->syarat, $m)) {
            $nextBadgeTarget = max(1, (int) $m[1]);
        }
        $nextBadgePct = $nextBadge ? min(100, (int) round(($totalLaporan / $nextBadgeTarget) * 100)) : 100;

        return view('student.dashboard', compact(
            'user',
            'siswa',
            'semester',
            'days',
            'periodeLabel',
            'completedWeekCount',
            'totalLaporan',
            'recentReports',
            'earnedBadges',
            'nextBadge',
            'nextBadgeTarget',
            'nextBadgePct'
        ));
    }

    public function createLaporan(Request $request)
    {
        $user = $request->user();
        $siswa = $this->currentSiswa($request);
        $kebiasaan = Kebiasaan::orderBy('id_kebiasaan')->get();

        $tanggal = $request->query('tanggal', now()->toDateString());
        $existing = Laporan::where('id_siswa', $siswa->id_siswa)
            ->whereDate('tanggal', $tanggal)
            ->first();

        return view('student.laporan', compact('user', 'siswa', 'kebiasaan', 'tanggal', 'existing'));
    }

    public function storeLaporan(Request $request)
    {
        $siswa = $this->currentSiswa($request);
        $kebiasaan = Kebiasaan::orderBy('id_kebiasaan')->get();

        $minDate = now()->subDays(7)->toDateString();
        $maxDate = now()->toDateString();

        $data = $request->validate([
            'tanggal'   => ['required', 'date', "after_or_equal:$minDate", "before_or_equal:$maxDate"],
            'kebiasaan' => ['required', 'array'],
            'catatan'   => ['nullable', 'string', 'max:500'],
        ], [
            'tanggal.after_or_equal'  => 'Laporan hanya dapat diisi maksimal 7 hari ke belakang.',
            'tanggal.before_or_equal' => 'Tidak dapat mengisi laporan untuk tanggal yang akan datang.',
        ]);

        $existingLaporan = Laporan::where('id_siswa', $siswa->id_siswa)->whereDate('tanggal', $data['tanggal'])->first();
        if ($existingLaporan && ($existingLaporan->status_verifikasi || $existingLaporan->id_guru_verifikator === null)) {
            return back()->withInput()->withErrors([
                'tanggal' => 'Laporan untuk tanggal ' . Carbon::parse($data['tanggal'])->translatedFormat('d F Y') . ' sudah pernah dikirim.',
            ]);
        }

        $semester = Semester::orderByDesc('id_semester')->first()
            ?? Semester::create([
                'tahun_ajaran'    => '2026/2027',
                'nama_semester'   => 'Ganjil',
                'tanggal_mulai'   => '2026-07-13',
                'tanggal_selesai' => '2026-12-19',
            ]);

        $newBadge = null;

        DB::transaction(function () use ($siswa, $semester, $data, $kebiasaan, $existingLaporan, &$newBadge) {
            if ($existingLaporan) {
                $laporan = $existingLaporan;
                $laporan->update([
                    'id_semester'         => $semester->id_semester,
                    'status_verifikasi'   => false,
                    'id_guru_verifikator' => null,
                    'catatan'             => $data['catatan'] ?? '',
                    'waktu_input'         => now(),
                ]);
                DetailLaporan::where('id_laporan', $laporan->id_laporan)->delete();
            } else {
                $laporan = Laporan::create([
                    'id_siswa'            => $siswa->id_siswa,
                    'id_semester'         => $semester->id_semester,
                    'status_verifikasi'   => false,
                    'id_guru_verifikator' => null,
                    'tanggal'             => $data['tanggal'],
                    'catatan'             => $data['catatan'] ?? '',
                    'waktu_input'         => now(),
                ]);
            }

            foreach ($kebiasaan as $keb) {
                $item = $data['kebiasaan'][$keb->id_kebiasaan] ?? [];
                $waktu = trim((string) ($item['waktu'] ?? ''));
                $ket = trim((string) ($item['keterangan'] ?? ''));
                if ($waktu !== '') {
                    $status = true;
                    $ket = $waktu . ' WITA';
                } else {
                    $status = ! empty($item['status']);
                    if ($ket === '') {
                        $ket = $status ? 'Terlaksana' : 'Belum dilaksanakan';
                    }
                }
                DetailLaporan::create([
                    'id_laporan'   => $laporan->id_laporan,
                    'id_kebiasaan' => $keb->id_kebiasaan,
                    'status'       => $status,
                    'keterangan'   => $ket,
                ]);
            }

            $total = Laporan::where('id_siswa', $siswa->id_siswa)->count();
            $earnedIds = BadgeSiswa::where('id_siswa', $siswa->id_siswa)->pluck('id_badge')->all();
            $thresholds = [
                'Pelajar Aktif'    => 1,
                'Bintang Ibadah'   => 3,
                'Pejuang Pagi'     => 5,
                'Konsisten 7 Hari' => 7,
                'Generasi Hebat'   => 14,
            ];

            foreach (Badge::all() as $badge) {
                $need = $thresholds[$badge->nama] ?? 999;
                if ($total >= $need && ! in_array($badge->id_badge, $earnedIds, true)) {
                    BadgeSiswa::create([
                        'id_siswa'       => $siswa->id_siswa,
                        'id_badge'       => $badge->id_badge,
                        'diperoleh_pada' => now(),
                    ]);
                    $newBadge = $badge;
                    break;
                }
            }
        });

        $redirect = redirect()->route('student.dashboard')->with('ok', 'Laporan harian berhasil disimpan.');
        if ($newBadge) {
            $redirect->with('badge_earned', [
                'nama'      => $newBadge->nama,
                'deskripsi' => $newBadge->deskripsi,
                'syarat'    => $newBadge->syarat,
            ]);
        }

        return $redirect;
    }

    public function riwayat(Request $request)
    {
        $user = $request->user();
        $siswa = $this->currentSiswa($request);
        $cari = $request->string('q')->trim()->toString();
        $status = $request->query('status', '');

        $reports = Laporan::with('guruVerifikator')
            ->where('id_siswa', $siswa->id_siswa)
            ->when($cari !== '', function ($q) use ($cari) {
                $cariEsc = addcslashes($cari, '%_\\');
                $q->where(fn ($w) => $w->where('tanggal', 'like', "%$cariEsc%")
                    ->orWhere('catatan', 'like', "%$cariEsc%"));
            })
            ->when($status === 'disetujui', fn ($q) => $q->where('status_verifikasi', true))
            ->when($status === 'menunggu', fn ($q) => $q->where('status_verifikasi', false)->whereNull('id_guru_verifikator'))
            ->when($status === 'ditolak', fn ($q) => $q->where('status_verifikasi', false)->whereNotNull('id_guru_verifikator'))
            ->orderByDesc('tanggal')
            ->paginate(10)
            ->withQueryString();

        return view('student.riwayat', compact('user', 'siswa', 'reports', 'status'));
    }

    public function detailRiwayat(Request $request, Laporan $laporan)
    {
        $user = $request->user();
        $siswa = $this->currentSiswa($request);
        abort_unless($laporan->id_siswa === $siswa->id_siswa, 403);

        $laporan->load(['details.kebiasaan', 'guruVerifikator']);

        return view('student.detail-riwayat', compact('user', 'siswa', 'laporan'));
    }

    public function lencana(Request $request)
    {
        $user = $request->user();
        $siswa = $this->currentSiswa($request);
        $tab = $request->query('tab', 'semua');

        $allBadges = Badge::all();
        $earnedMap = BadgeSiswa::where('id_siswa', $siswa->id_siswa)
            ->get()
            ->keyBy('id_badge');

        $totalLaporan = Laporan::where('id_siswa', $siswa->id_siswa)->count();

        return view('student.lencana', compact('user', 'siswa', 'allBadges', 'earnedMap', 'tab', 'totalLaporan'));
    }

    public function profil(Request $request)
    {
        $user = $request->user();
        $siswa = $this->currentSiswa($request);

        return view('student.profil', compact('user', 'siswa'));
    }

    public function updateProfil(Request $request)
    {
        $user = $request->user();
        $siswa = $this->currentSiswa($request);

        $data = $request->validate([
            'name'  => ['required', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:150'],
        ]);

        $user->update($data);
        $siswa->update(['nama_siswa' => $data['name']]);

        return back()->with('ok', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ], [
            'current_password.current_password' => 'Kata sandi saat ini tidak sesuai.',
            'password.confirmed'                => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $user->update(['password' => $data['password']]);

        return back()->with('ok', 'Kata sandi berhasil diperbarui.');
    }
}
