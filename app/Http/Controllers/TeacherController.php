<?php

namespace App\Http\Controllers;

use App\Models\GuruWali;
use App\Models\Kelas;
use App\Models\Laporan;
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
            ->orderBy('nama_siswa')
            ->get();

        $siswaIds = $siswaList->pluck('id_siswa');
        $disetujui = Laporan::whereIn('id_siswa', $siswaIds)->where('status_verifikasi', true)->count();
        $ditolak = Laporan::whereIn('id_siswa', $siswaIds)->where('status_verifikasi', false)->whereNotNull('id_guru_verifikator')->count();
        $menunggu = Laporan::whereIn('id_siswa', $siswaIds)->where('status_verifikasi', false)->whereNull('id_guru_verifikator')->count();

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

        return view('teacher.detail-laporan', compact('user', 'guru', 'laporan'));
    }

    public function verifyLaporan(Request $request, Laporan $laporan)
    {
        $guru = $this->currentGuru($request);

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

    public function detailSiswa(Request $request, Siswa $siswa)
    {
        $user = $request->user();
        $guru = $this->currentGuru($request);
        $siswa->load([
            'kelas',
            'guruWali',
            'badgeSiswa.badge',
            'laporan' => fn ($q) => $q->orderByDesc('tanggal')->with('details'),
        ]);
        $totalBadgeMaster = \App\Models\Badge::count();
        $nextBadge = \App\Models\Badge::whereNotIn('id_badge', $siswa->badgeSiswa->pluck('id_badge'))->first();
        $semester = \App\Models\Semester::orderByDesc('id_semester')->first();

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

        // Series per periode untuk Grafik Perkembangan (Harian, Mingguan, Bulanan, Semester)
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
