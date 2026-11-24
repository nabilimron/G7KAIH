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
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    private function currentGuru(Request $request): GuruWali
    {
        $user = $request->user();
        $guru = GuruWali::where('user_id', $user->id)->first();
        if (! $guru) {
            $guru = GuruWali::firstOrFail();
        }

        return $guru;
    }

    public function dashboard(Request $request)
    {
        $user = $request->user();
        $guru = $this->currentGuru($request);

        $siswaList = Siswa::with('kelas')
            ->where('id_guru', $guru->id_guru)
            ->withCount([
                'laporan as total_laporan_count',
                'laporan as disetujui_count' => fn ($q) => $q->where('status_verifikasi', true),
                'laporan as ditolak_count' => fn ($q) => $q->where('status_verifikasi', false)->whereNotNull('id_guru_verifikator'),
                'laporan as menunggu_count' => fn ($q) => $q->where('status_verifikasi', false)->whereNull('id_guru_verifikator'),
            ])
            ->orderBy('nama_siswa')
            ->get();

        $siswaIds = $siswaList->pluck('id_siswa');
        $disetujui = Laporan::whereIn('id_siswa', $siswaIds)->where('status_verifikasi', true)->count();
        $ditolak = Laporan::whereIn('id_siswa', $siswaIds)->where('status_verifikasi', false)->whereNotNull('id_guru_verifikator')->count();
        $menunggu = Laporan::whereIn('id_siswa', $siswaIds)->where('status_verifikasi', false)->whereNull('id_guru_verifikator')->count();
        $totalLaporan = $disetujui + $ditolak + $menunggu;
        $pctVerif = $totalLaporan > 0 ? (int) round(($disetujui / $totalLaporan) * 100) : 0;
        $pctMenunggu = $totalLaporan > 0 ? round(($menunggu / $totalLaporan) * 100, 1) : 0;
        $pctDitolak = $totalLaporan > 0 ? round(($ditolak / $totalLaporan) * 100, 1) : 0;

        $kelopakColors = ['#17B979', '#E34557', '#238CE2', '#EFBD37', '#34B6CA', '#2B64B7', '#31AA63'];
        $kebiasaanList = Kebiasaan::orderBy('id_kebiasaan')->get();
        $detailCounts = DetailLaporan::whereHas('laporan', fn ($q) => $q->whereIn('id_siswa', $siswaIds))
            ->selectRaw('id_kebiasaan, COUNT(*) as total, SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as done')
            ->groupBy('id_kebiasaan')
            ->get()
            ->keyBy('id_kebiasaan');

        $habitStats = $kebiasaanList->values()->map(function ($k, $idx) use ($detailCounts, $kelopakColors) {
            $row = $detailCounts->get($k->id_kebiasaan);
            $tot = $row ? (int) $row->total : 0;
            $done = $row ? (int) $row->done : 0;
            $pct = $tot > 0 ? (int) round(($done / $tot) * 100) : 0;

            return [
                'nama' => ($idx + 1) . '. ' . $k->nama_kebiasaan,
                'pct' => $pct,
                'color' => $kelopakColors[$idx % count($kelopakColors)],
                'done' => $done,
                'total' => $tot,
            ];
        });

        $pendingReports = Laporan::with('siswa.kelas')
            ->whereIn('id_siswa', $siswaIds)
            ->where('status_verifikasi', false)
            ->whereNull('id_guru_verifikator')
            ->orderByDesc('tanggal')
            ->limit(5)
            ->get();

        return view('teacher.dashboard', compact(
            'user',
            'guru',
            'siswaList',
            'disetujui',
            'ditolak',
            'menunggu',
            'totalLaporan',
            'pctVerif',
            'pctMenunggu',
            'pctDitolak',
            'habitStats',
            'pendingReports'
        ));
    }

    public function verifikasi(Request $request)
    {
        $user = $request->user();
        $guru = $this->currentGuru($request);
        $status = $request->query('status', '');
        $idKelas = $request->query('id_kelas', '');
        $tanggal = $request->query('tanggal', '');
        $search = trim((string) $request->query('q', ''));

        $siswaQuery = Siswa::where('id_guru', $guru->id_guru);
        $kelasList = Kelas::whereIn('id_kelas', (clone $siswaQuery)->pluck('id_kelas')->unique())->orderBy('nama_kelas')->get();
        if ($idKelas !== '') {
            $siswaQuery->where('id_kelas', $idKelas);
        }
        $siswaIds = $siswaQuery->pluck('id_siswa');

        $reports = Laporan::with('siswa.kelas')
            ->whereIn('id_siswa', $siswaIds)
            ->when($status === 'menunggu', fn ($q) => $q->where('status_verifikasi', false)->whereNull('id_guru_verifikator'))
            ->when($status === 'disetujui', fn ($q) => $q->where('status_verifikasi', true))
            ->when($status === 'ditolak', fn ($q) => $q->where('status_verifikasi', false)->whereNotNull('id_guru_verifikator'))
            ->when($tanggal !== '', fn ($q) => $q->whereDate('tanggal', $tanggal))
            ->when($search !== '', fn ($q) => $q->whereHas('siswa', fn ($sq) => $sq->where('nama_siswa', 'like', "%{$search}%")->orWhere('nisn', 'like', "%{$search}%")))
            ->orderByDesc('tanggal')
            ->paginate(12)
            ->withQueryString();

        return view('teacher.verifikasi', compact('user', 'guru', 'reports', 'kelasList', 'idKelas', 'status', 'tanggal', 'search'));
    }

    public function detailLaporan(Request $request, Laporan $laporan)
    {
        $user = $request->user();
        $guru = $this->currentGuru($request);
        $laporan->load(['siswa.kelas', 'details.kebiasaan', 'guruVerifikator']);
        abort_unless($laporan->siswa && $laporan->siswa->id_guru === $guru->id_guru, 403);

        return view('teacher.detail-laporan', compact('user', 'guru', 'laporan'));
    }

    public function verifyLaporan(Request $request, Laporan $laporan)
    {
        $guru = $this->currentGuru($request);
        $laporan->load('siswa');
        abort_unless($laporan->siswa && $laporan->siswa->id_guru === $guru->id_guru, 403);

        $data = $request->validate([
            'keputusan' => ['required', 'in:setujui,tolak'],
            'catatan'   => ['nullable', 'string', 'max:500'],
        ]);

        if ($data['keputusan'] === 'setujui') {
            $laporan->update([
                'status_verifikasi'   => true,
                'id_guru_verifikator' => $guru->id_guru,
                'catatan'             => $data['catatan'] ?: 'Laporan diterima dan telah diverifikasi.',
            ]);
            $this->evaluateBadgesForStudent($laporan->id_siswa);
            $msg = 'Laporan siswa berhasil disetujui.';
        } else {
            $laporan->update([
                'status_verifikasi'   => false,
                'id_guru_verifikator' => $guru->id_guru,
                'catatan'             => $data['catatan'] ?: 'Perlu perbaikan pada laporan kebiasaan.',
            ]);
            $msg = 'Laporan siswa dikembalikan untuk revisi.';
        }

        return redirect()->route('teacher.verifikasi')->with('ok', $msg);
    }

    private function evaluateBadgesForStudent(int $idSiswa): void
    {
        $approvedCount = Laporan::where('id_siswa', $idSiswa)->where('status_verifikasi', true)->count();
        $earnedIds = BadgeSiswa::where('id_siswa', $idSiswa)->pluck('id_badge')->all();
        $thresholds = [
            'Pejuang Pagi'     => 1,
            'Bintang Ibadah'   => 3,
            'Pelajar Aktif'    => 5,
            'Konsisten 7 Hari' => 7,
            'Aktif Bergerak'   => 10,
            'Generasi Hebat'   => 14,
        ];

        foreach (Badge::all() as $badge) {
            $need = $thresholds[$badge->nama] ?? null;
            if ($need !== null && $approvedCount >= $need && ! in_array($badge->id_badge, $earnedIds, true)) {
                BadgeSiswa::create([
                    'id_siswa'       => $idSiswa,
                    'id_badge'       => $badge->id_badge,
                    'diperoleh_pada' => now(),
                ]);
            }
        }
    }

    public function detailSiswa(Request $request, Siswa $siswa)
    {
        $user = $request->user();
        $guru = $this->currentGuru($request);
        abort_unless($siswa->id_guru === $guru->id_guru, 403);

        $siswa->load([
            'kelas',
            'guruWali',
            'badgeSiswa.badge',
            'laporan' => fn ($q) => $q->orderByDesc('tanggal')->with('details'),
        ]);
        $totalBadgeMaster = Badge::count();
        $nextBadge = Badge::whereNotIn('id_badge', $siswa->badgeSiswa->pluck('id_badge'))->first();
        $semester = Semester::orderByDesc('id_semester')->first();

        return view('teacher.detail-siswa', compact('user', 'guru', 'siswa', 'totalBadgeMaster', 'nextBadge', 'semester'));
    }

    public function rekapitulasi(Request $request)
    {
        $user = $request->user();
        $guru = $this->currentGuru($request);
        $periode = $request->query('periode', 'mingguan');
        $tanggal = $request->query('tanggal', '');
        $idKelas = $request->query('id_kelas', '');

        $allKelasIds = Siswa::where('id_guru', $guru->id_guru)->pluck('id_kelas')->unique();
        $kelasList = Kelas::whereIn('id_kelas', $allKelasIds)->orderBy('nama_kelas')->get();

        $siswaList = Siswa::with(['kelas', 'laporan' => function ($q) use ($periode, $tanggal) {
            if ($tanggal !== '') {
                $q->whereDate('tanggal', $tanggal);
            } elseif ($periode === 'harian') {
                $q->whereDate('tanggal', now()->toDateString());
            } elseif ($periode === 'mingguan') {
                $q->where('tanggal', '>=', now()->subDays(7)->toDateString());
            } elseif ($periode === 'bulanan') {
                $q->whereMonth('tanggal', now()->month)->whereYear('tanggal', now()->year);
            }
        }])
            ->where('id_guru', $guru->id_guru)
            ->when($idKelas !== '', fn ($q) => $q->where('id_kelas', $idKelas))
            ->orderBy('nama_siswa')
            ->get();

        $totalSiswa = $siswaList->count();
        $allLaporan = $siswaList->flatMap->laporan;
        $totalLaporan = $allLaporan->count();
        $disetujui = $allLaporan->where('status_verifikasi', true)->count();
        $ditolak = $allLaporan->where('status_verifikasi', false)->whereNotNull('id_guru_verifikator')->count();

        $rekapKelas = $siswaList
            ->groupBy(fn ($s) => $s->kelas->nama_kelas ?? '-')
            ->map(function ($group, $namaKelas) {
                $laps = $group->flatMap->laporan;

                return [
                    'kelas' => $namaKelas,
                    'total' => $laps->count(),
                    'ok'    => $laps->where('status_verifikasi', true)->count(),
                    'no'    => $laps->where('status_verifikasi', false)->whereNotNull('id_guru_verifikator')->count(),
                ];
            })
            ->values();

        $siswaIdsAll = Siswa::where('id_guru', $guru->id_guru)
            ->when($idKelas !== '', fn ($q) => $q->where('id_kelas', $idKelas))
            ->pluck('id_siswa');
        $lapsAll = Laporan::whereIn('id_siswa', $siswaIdsAll)->get();
        $chartSeries = [
            ['label' => 'Harian', 'ok' => $lapsAll->filter(fn ($l) => $l->status_verifikasi && $l->tanggal->isToday())->count(), 'no' => $lapsAll->filter(fn ($l) => ! $l->status_verifikasi && $l->id_guru_verifikator && $l->tanggal->isToday())->count()],
            ['label' => 'Mingguan', 'ok' => $lapsAll->filter(fn ($l) => $l->status_verifikasi && $l->tanggal->gte(now()->subDays(7)))->count(), 'no' => $lapsAll->filter(fn ($l) => ! $l->status_verifikasi && $l->id_guru_verifikator && $l->tanggal->gte(now()->subDays(7)))->count()],
            ['label' => 'Bulanan', 'ok' => $lapsAll->filter(fn ($l) => $l->status_verifikasi && $l->tanggal->month === now()->month && $l->tanggal->year === now()->year)->count(), 'no' => $lapsAll->filter(fn ($l) => ! $l->status_verifikasi && $l->id_guru_verifikator && $l->tanggal->month === now()->month && $l->tanggal->year === now()->year)->count()],
            ['label' => 'Semester', 'ok' => $lapsAll->where('status_verifikasi', true)->count(), 'no' => $lapsAll->where('status_verifikasi', false)->whereNotNull('id_guru_verifikator')->count()],
        ];

        return view('teacher.rekapitulasi', compact(
            'user',
            'guru',
            'siswaList',
            'kelasList',
            'periode',
            'tanggal',
            'idKelas',
            'totalSiswa',
            'totalLaporan',
            'disetujui',
            'ditolak',
            'rekapKelas',
            'chartSeries'
        ));
    }

    public function profil(Request $request)
    {
        $user = $request->user();
        $guru = $this->currentGuru($request);
        $siswaList = Siswa::with('kelas')->where('id_guru', $guru->id_guru)->get();
        $kelasWali = $siswaList->first()?->kelas->nama_kelas ?? '-';
        $jumlahSiswa = $siswaList->count();
        $semester = Semester::orderByDesc('id_semester')->first();

        return view('teacher.profil', compact('user', 'guru', 'kelasWali', 'jumlahSiswa', 'semester'));
    }

    public function updateProfil(Request $request)
    {
        $guru = $this->currentGuru($request);
        $data = $request->validate([
            'nama_guru' => ['required', 'string', 'max:100'],
            'no_hp'     => ['nullable', 'string', 'max:30'],
        ]);

        $guru->update($data);
        $request->user()?->update(['name' => $data['nama_guru']]);

        return back()->with('ok', 'Profil Guru Wali berhasil diperbarui.');
    }
}
