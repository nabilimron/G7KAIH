@extends('layout.admin')
@section('title', 'Dashboard Admin')
@section('footer_note', 'Terakhir diperbarui pukul ' . now()->format('H.i') . ' WITA')

@section('content')
<section class="view on" id="dash">
 <div class="top">
  <div><h1>Dashboard Admin</h1><p class="sub">Pantau pelaksanaan 7 Kebiasaan Anak Indonesia Hebat di sekolah.</p></div>
  <div class="date"><span data-i="calendar-days"></span>{{ now()->translatedFormat('l, d F Y') }}</div>
 </div>

 <div class="g4">
  <div class="stat"><div><span>Total siswa</span><span class="ib"><span data-i="users-round"></span></span></div><b>{{ $totalSiswa }}</b><small>Terdaftar di db_g7kaih</small></div>
  <div class="stat"><div><span>Guru wali</span><span class="ib"><span data-i="user-round-check"></span></span></div><b>{{ $totalGuru }}</b><small>Seluruh akun aktif</small></div>
  <div class="stat"><div><span>Perwalian terisi</span><span class="ib"><span data-i="school"></span></span></div><b>{{ $perwalianTerisi }} / {{ $totalSiswa }}</b><small>{{ max(0, $totalSiswa - $perwalianTerisi) }} siswa belum memiliki wali</small></div>
  <div class="stat"><div><span>Total laporan</span><span class="ib"><span data-i="file-text"></span></span></div><b>{{ $totalLaporan }}</b><small class="up">Tersimpan di database</small></div>
 </div>

 <div class="g2">
  <div class="card">
   <div class="row" style="align-items:center">
    <div style="flex:1"><h2>Tren pelaporan</h2><p class="ps">Jumlah laporan masuk setiap hari</p></div>
    <div class="ctl h28" style="width:130px;">
     <select aria-label="Rentang tren">
      <option selected>7 hari terakhir</option>
     </select>
     <span data-i="chevron-down"></span>
    </div>
   </div>
   <div style="display:flex;align-items:baseline;gap:8px;">
    <b style="font-size:24px;font-weight:700;">{{ $totalLaporan }}</b>
    <span style="color:var(--mut);font-size:11px;">laporan</span>
   </div>
   <div class="plot">
    <div class="ylab">
     <span>{{ $maxTrend }}</span>
     <span>{{ (int) round($maxTrend / 2) }}</span>
     <span>0</span>
    </div>
    <div class="bars">
     <div class="pl">
      @foreach ($trendBars as $bar)
       <i title="{{ $bar['label'] }}: {{ $bar['count'] }} laporan" style="height:{{ $bar['pct'] }}%"></i>
      @endforeach
     </div>
     <div class="days">
      @foreach ($trendBars as $bar)
       <span>{{ $bar['label'] }}</span>
      @endforeach
     </div>
    </div>
   </div>
   <small style="color:var(--mut);font-size:10px;">{{ now()->subDays(6)->translatedFormat('d') }}&ndash;{{ now()->translatedFormat('d F Y') }} &middot; Seluruh kelas</small>
  </div>

  <div class="card">
   <div><h2>Status verifikasi</h2><p class="ps">Seluruh laporan di database</p></div>
   <div style="display:flex;gap:8px;align-items:baseline"><b style="font-size:28px">{{ $pctVerif }}%</b><span style="color:var(--mut);font-size:11px">telah diverifikasi</span></div>
   <div class="seg">
    <i style="background:var(--ok);flex:{{ max(1, $terverifikasi) }}"></i>
    <i style="background:#b77913;flex:{{ max(1, $menunggu) }}"></i>
    <i style="background:var(--bad);flex:{{ max(1, $ditolak) }}"></i>
   </div>
   <div style="display:flex;flex-direction:column;gap:14px">
    <div class="st"><i style="background:var(--ok)"></i><span>Terverifikasi</span><b>{{ $terverifikasi }}</b><em>{{ $pctVerif }}%</em></div>
    <div class="st"><i style="background:#b77913"></i><span>Menunggu verifikasi</span><b>{{ $menunggu }}</b><em>{{ $pctMenunggu }}%</em></div>
    <div class="st"><i style="background:var(--bad)"></i><span>Perlu perbaikan</span><b>{{ $ditolak }}</b><em>{{ $pctDitolak }}%</em></div>
   </div>
   <a class="lnk" href="{{ route('admin.laporan') }}">Lihat pemantauan keseluruhan <span data-i="arrow-right" style="font-size:15px"></span></a>
  </div>
 </div>

 <div class="g2">
  <div class="card">
   <div class="row" style="align-items:center"><h2 style="flex:1">Aktivitas terbaru</h2><a href="{{ route('admin.laporan') }}" style="color:var(--pri);font-weight:600;font-size:11px">Lihat semua</a></div>
   @forelse ($recentLaporan as $lap)
    <div class="act">
     <div class="c" style="background:{{ $lap->status_verifikasi ? '#e9f6f1' : '#fff6e5' }};color:{{ $lap->status_verifikasi ? 'var(--ok)' : '#b77913' }}">
      <span data-i="file-check"></span>
     </div>
     <div>
      {{ $lap->siswa->nama_siswa ?? 'Siswa' }} ({{ $lap->siswa->kelas->nama_kelas ?? '-' }})
      <small>{{ $lap->statusLabel() }} &middot; {{ $lap->catatan ?: 'Laporan 7 Kebiasaan' }}</small>
     </div>
     <span>{{ $lap->tanggal->translatedFormat('d M Y') }}</span>
    </div>
   @empty
    <p style="color:var(--mut);font-size:12px;">Belum ada laporan masuk.</p>
   @endforelse
  </div>

  <div class="card">
   <div><h2>Akses cepat</h2></div>
   <div>
    <a class="act" href="{{ route('akun.index') }}">
     <div class="c q" style="background:var(--soft);color:var(--pri)"><span data-i="users-round"></span></div>
     <div>Kelola Akun &amp; Pengguna<small>Tambah dan atur akses pengguna</small></div>
     <span data-i="chevron-right"></span>
    </a>
    <a class="act" href="{{ route('admin.perwalian') }}">
     <div class="c q" style="background:var(--soft);color:var(--pri)"><span data-i="school"></span></div>
     <div>Atur Perwalian<small>Lengkapi siswa yang belum memiliki guru wali</small></div>
     <span data-i="chevron-right"></span>
    </a>
    <a class="act" href="{{ route('admin.badge') }}">
     <div class="c q" style="background:var(--soft);color:var(--pri)"><span data-i="award"></span></div>
     <div>Badge Pencapaian<small>Kelola penghargaan kebiasaan siswa</small></div>
     <span data-i="chevron-right"></span>
    </a>
    <a class="act" href="{{ route('admin.laporan') }}">
     <div class="c q" style="background:var(--soft);color:var(--pri)"><span data-i="chart-column"></span></div>
     <div>Pemantauan Keseluruhan<small>Tinjau seluruh laporan dan verifikasi</small></div>
     <span data-i="chevron-right"></span>
    </a>
   </div>
  </div>
 </div>
</section>
@endsection

@push('scripts')
<script>paint();</script>
@endpush
