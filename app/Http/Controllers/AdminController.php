<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\GuruWali;
use App\Models\Kelas;
use App\Models\Laporan;
use App\Models\Semester;
use App\Models\Siswa;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalSiswa = Siswa::count();
        $totalGuru = GuruWali::count();
        $perwalianTerisi = Siswa::whereNotNull('id_guru')->count();
        $totalLaporan = Laporan::count();

        $terverifikasi = Laporan::where('status_verifikasi', true)->count();
        $ditolak = Laporan::where('status_verifikasi', false)->whereNotNull('id_guru_verifikator')->count();
        $menunggu = Laporan::where('status_verifikasi', false)->whereNull('id_guru_verifikator')->count();

        $pctVerif = $totalLaporan > 0 ? round(($terverifikasi / $totalLaporan) * 100, 1) : 0;
        $pctMenunggu = $totalLaporan > 0 ? round(($menunggu / $totalLaporan) * 100, 1) : 0;
        $pctDitolak = $totalLaporan > 0 ? round(($ditolak / $totalLaporan) * 100, 1) : 0;

        $recentLaporan = Laporan::with(['siswa.kelas', 'guruVerifikator'])
            ->orderByDesc('waktu_input')
            ->limit(5)
            ->get();

        $dayMap = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        $rawCounts = Laporan::selectRaw('DATE(tanggal) as tgl, COUNT(*) as jml')
            ->where('tanggal', '>=', now()->subDays(6)->toDateString())
            ->groupBy('tgl')
            ->pluck('jml', 'tgl');

        $trendBars = collect(range(6, 0))->map(function (int $offset) use ($dayMap, $rawCounts) {
            $d = now()->subDays($offset);
            $cnt = (int) ($rawCounts[$d->toDateString()] ?? 0);

            return [
                'label' => $dayMap[$d->dayOfWeek],
                'count' => $cnt,
            ];
        });
        $maxTrend = max(1, $trendBars->max('count'));
        $trendBars = $trendBars->map(function (array $bar) use ($maxTrend) {
            $bar['pct'] = $bar['count'] > 0 ? max(12, (int) round(($bar['count'] / $maxTrend) * 100)) : 4;

            return $bar;
        });

        $kelasDistribusi = Kelas::orderBy('nama_kelas')->get()->map(function (Kelas $k) {
            $sIds = Siswa::where('id_kelas', $k->id_kelas)->pluck('id_siswa');
            $ok = Laporan::whereIn('id_siswa', $sIds)->where('status_verifikasi', true)->count();
            $no = Laporan::whereIn('id_siswa', $sIds)->where('status_verifikasi', false)->whereNotNull('id_guru_verifikator')->count();
            $wait = Laporan::whereIn('id_siswa', $sIds)->where('status_verifikasi', false)->whereNull('id_guru_verifikator')->count();
            $tot = $ok + $no + $wait;

            return [
                'kelas' => $k->nama_kelas,
                'ok' => $ok,
                'wait' => $wait,
                'no' => $no,
                'total' => $tot,
                'pct' => $tot > 0 ? (int) round(($ok / $tot) * 100) : 0,
            ];
        });

        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalGuru',
            'perwalianTerisi',
            'totalLaporan',
            'terverifikasi',
            'menunggu',
            'ditolak',
            'pctVerif',
            'pctMenunggu',
            'pctDitolak',
            'recentLaporan',
            'trendBars',
            'maxTrend',
            'kelasDistribusi'
        ));
    }

    public function perwalian(Request $request)
    {
        $idKelas = $request->query('id_kelas', '');
        $idGuru = $request->query('id_guru', '');

        $siswaList = Siswa::with(['kelas', 'guruWali'])
            ->when($idKelas !== '', fn ($q) => $q->where('id_kelas', $idKelas))
            ->when($idGuru !== '', fn ($q) => $q->where('id_guru', $idGuru))
            ->orderBy('nama_siswa')
            ->get();
        $guruList = GuruWali::orderBy('nama_guru')->get();
        $kelasList = Kelas::orderBy('nama_kelas')->get();

        $kelasRows = $kelasList
            ->when($idKelas !== '', fn ($c) => $c->where('id_kelas', (int) $idKelas))
            ->map(function (Kelas $k) use ($siswaList) {
                $murid = $siswaList->where('id_kelas', $k->id_kelas)->values();
                $guruWali = $murid->first()?->guruWali;

                return [
                    'kelas'  => $k,
                    'guru'   => $guruWali,
                    'jumlah' => $murid->count(),
                    'siswa'  => $murid,
                ];
            })
            ->filter(fn ($row) => $idGuru === '' || ($row['guru'] && (string) $row['guru']->id_guru === (string) $idGuru))
            ->values();

        return view('admin.perwalian', compact('siswaList', 'guruList', 'kelasList', 'kelasRows', 'idKelas', 'idGuru'));
    }

    public function updateKelasPerwalian(Request $request, Kelas $kelas)
    {
        $data = $request->validate([
            'id_guru' => ['required', 'exists:guru_wali,id_guru'],
        ]);

        Siswa::where('id_kelas', $kelas->id_kelas)->update(['id_guru' => $data['id_guru']]);

        return back()->with('ok', 'Guru wali kelas ' . $kelas->nama_kelas . ' berhasil diperbarui.');
    }

    public function updatePerwalian(Request $request, Siswa $siswa)
    {
        $data = $request->validate([
            'id_guru'  => ['required', 'exists:guru_wali,id_guru'],
            'id_kelas' => ['required', 'exists:kelas,id_kelas'],
        ]);

        $siswa->update($data);

        return back()->with('ok', 'Perwalian untuk ' . $siswa->nama_siswa . ' berhasil diperbarui.');
    }

    public function badge()
    {
        $badges = Badge::withCount([])->get();
        return view('admin.badge', compact('badges'));
    }

    public function storeBadge(Request $request)
    {
        $data = $request->validate([
            'nama'      => ['required', 'string', 'max:100'],
            'deskripsi' => ['required', 'string', 'max:255'],
            'syarat'    => ['required', 'string', 'max:100'],
        ]);

        Badge::create($data);

        return back()->with('ok', 'Badge "' . $data['nama'] . '" berhasil ditambahkan.');
    }

    public function updateBadge(Request $request, Badge $badge)
    {
        $data = $request->validate([
            'nama'      => ['required', 'string', 'max:100'],
            'deskripsi' => ['required', 'string', 'max:255'],
            'syarat'    => ['required', 'string', 'max:100'],
        ]);

        $badge->update($data);

        return back()->with('ok', 'Badge "' . $data['nama'] . '" berhasil diperbarui.');
    }

    public function destroyBadge(Badge $badge)
    {
        $nama = $badge->nama;
        $badge->delete();

        return back()->with('ok', 'Badge "' . $nama . '" berhasil dihapus.');
    }

    public function laporan(Request $request)
    {
        $periode = $request->query('periode', '');
        $status = $request->query('status', '');
        $tanggal = $request->query('tanggal', '');
        $idKelas = $request->query('id_kelas', '');

        $reports = Laporan::with(['siswa.kelas', 'guruVerifikator'])
            ->when($periode === 'harian', fn ($q) => $q->whereDate('tanggal', now()->toDateString()))
            ->when($periode === 'mingguan', fn ($q) => $q->where('tanggal', '>=', now()->subDays(7)->toDateString()))
            ->when($periode === 'bulanan', fn ($q) => $q->whereMonth('tanggal', now()->month)->whereYear('tanggal', now()->year))
            ->when($status === 'disetujui', fn ($q) => $q->where('status_verifikasi', true))
            ->when($status === 'menunggu', fn ($q) => $q->where('status_verifikasi', false)->whereNull('id_guru_verifikator'))
            ->when($status === 'ditolak', fn ($q) => $q->where('status_verifikasi', false)->whereNotNull('id_guru_verifikator'))
            ->when($tanggal !== '', fn ($q) => $q->whereDate('tanggal', $tanggal))
            ->when($idKelas !== '', fn ($q) => $q->whereHas('siswa', fn ($sq) => $sq->where('id_kelas', $idKelas)))
            ->orderByDesc('tanggal')
            ->paginate(15)
            ->withQueryString();

        $totalLaporan = Laporan::count();
        $disetujui = Laporan::where('status_verifikasi', true)->count();
        $ditolak = Laporan::where('status_verifikasi', false)->whereNotNull('id_guru_verifikator')->count();
        $menunggu = Laporan::where('status_verifikasi', false)->whereNull('id_guru_verifikator')->count();
        $kelasList = Kelas::orderBy('nama_kelas')->get();

        return view('admin.laporan', compact(
            'reports',
            'periode',
            'status',
            'tanggal',
            'idKelas',
            'totalLaporan',
            'disetujui',
            'menunggu',
            'ditolak',
            'kelasList'
        ));
    }

    public function pengaturan(Request $request)
    {
        $semester = Semester::orderByDesc('id_semester')->first();
        $admin = $request->user();

        return view('admin.pengaturan', compact('semester', 'admin'));
    }

    public function updatePengaturan(Request $request)
    {
        $data = $request->validate([
            'tahun_ajaran'     => ['required', 'string', 'max:20'],
            'nama_semester'    => ['required', 'in:Ganjil,Genap'],
            'password'         => ['nullable', 'confirmed', 'min:8'],
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
        ]);

        $semester = Semester::orderByDesc('id_semester')->first();
        if ($semester) {
            $semester->update([
                'tahun_ajaran'  => $data['tahun_ajaran'],
                'nama_semester' => $data['nama_semester'],
            ]);
        }

        if (! empty($data['password']) && $request->user()) {
            $request->user()->update(['password' => $data['password']]);
        }

        return back()->with('ok', 'Pengaturan admin berhasil disimpan.');
    }
}
