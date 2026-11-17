@extends('layout.teacher')
@section('title', 'Rekapitulasi Data Laporan')

@section('content')
<section class="view on">
 <div class="top">
  <div><h1>Rekapitulasi Data Laporan</h1><p class="sub">Ringkasan pelaporan dan perkembangan kebiasaan siswa.</p></div>
 </div>

 {{-- Filter 3 Kolom (Figma 2:58195) --}}
 <form method="GET" action="{{ route('teacher.rekapitulasi') }}" class="g3">
  <div class="fld">
   <label for="r_periode">Periode</label>
   <div class="ctl">
    <select id="r_periode" name="periode" onchange="this.form.submit()">
     <option value="mingguan" @selected($periode === 'mingguan')>Mingguan</option>
     <option value="harian" @selected($periode === 'harian')>Harian</option>
     <option value="bulanan" @selected($periode === 'bulanan')>Bulanan</option>
     <option value="semua" @selected($periode === 'semua')>Semester</option>
    </select>
    <span data-i="chevron-down"></span>
   </div>
  </div>
  <div class="fld">
   <label for="r_tanggal">Rentang Tanggal</label>
   <div class="ctl">
    <input id="r_tanggal" type="date" name="tanggal" value="{{ $tanggal }}" onchange="this.form.submit()">
   </div>
  </div>
  <div class="fld">
   <label for="r_kelas">Kelas</label>
   <div class="ctl">
    <select id="r_kelas" name="id_kelas" onchange="this.form.submit()">
     <option value="">Semua Kelas</option>
     @foreach ($kelasList as $k)
      <option value="{{ $k->id_kelas }}" @selected((string) $idKelas === (string) $k->id_kelas)>{{ $k->nama_kelas }}</option>
     @endforeach
    </select>
    <span data-i="chevron-down"></span>
   </div>
  </div>
 </form>

 <div class="mt4">
  <div>
   <span class="ib" style="background:var(--soft);color:var(--pri)"><span data-i="users-round"></span></span>
   <div><small>Total Siswa</small><b style="color:var(--pri)">{{ $totalSiswa }}</b></div>
  </div>
  <div>
   <span class="ib" style="background:var(--soft);color:var(--pri)"><span data-i="clipboard-list"></span></span>
   <div><small>Total Laporan</small><b style="color:var(--pri)">{{ $totalLaporan }}</b></div>
  </div>
  <div>
   <span class="ib" style="background:#e5f8f0;color:#10a874"><span data-i="circle-check"></span></span>
   <div><small>Disetujui</small><b style="color:#10a874">{{ $disetujui }}</b></div>
  </div>
  <div>
   <span class="ib" style="background:#fff0f2;color:#f04462"><span data-i="circle-x"></span></span>
   <div><small>Ditolak</small><b style="color:#f04462">{{ $ditolak }}</b></div>
  </div>
 </div>

 <div class="g2 eq">
  <div class="card sh">
   <h2>Rekap per Kelas</h2>
   <div class="tw">
    <table style="min-width:100%;">
     <thead><tr><th>Kelas</th><th>Total Laporan</th><th>Disetujui</th><th>Ditolak</th></tr></thead>
     <tbody>
      @forelse ($rekapKelas as $rk)
       <tr>
        <td>{{ $rk['kelas'] }}</td>
        <td>{{ $rk['total'] }}</td>
        <td>{{ $rk['ok'] }}</td>
        <td>{{ $rk['no'] }}</td>
       </tr>
      @empty
       <tr><td colspan="4" style="text-align:center;color:var(--mut);padding:20px;">Belum ada data.</td></tr>
      @endforelse
      @if ($rekapKelas->isNotEmpty())
       <tr>
        <td><strong>Total</strong></td>
        <td><strong>{{ $totalLaporan }}</strong></td>
        <td><strong>{{ $disetujui }}</strong></td>
        <td><strong>{{ $ditolak }}</strong></td>
       </tr>
      @endif
     </tbody>
    </table>
   </div>
  </div>

  <div class="card sh">
   <div class="row" style="align-items:center;">
    <h2 style="flex:1">Grafik Perkembangan</h2>
    <div style="display:flex;gap:12px;font-size:10px;color:var(--mut);">
     <span style="display:inline-flex;align-items:center;gap:5px;"><i style="width:10px;height:4px;border-radius:2px;background:#07805d;display:inline-block;"></i>Disetujui</span>
     <span style="display:inline-flex;align-items:center;gap:5px;"><i style="width:10px;height:4px;border-radius:2px;background:#f04462;display:inline-block;"></i>Ditolak</span>
    </div>
   </div>
   @php
    $maxG = max(1, collect($chartSeries)->max(fn($c) => max($c['ok'], $c['no'])));
   @endphp
   <div class="plot">
    <div class="ylab"><span>{{ $maxG }}</span><span>{{ (int) round($maxG * 0.75) }}</span><span>{{ (int) round($maxG * 0.5) }}</span><span>{{ (int) round($maxG * 0.25) }}</span><span>0</span></div>
    <div class="bars">
     <div class="pl" style="align-items:flex-end;justify-content:space-around;gap:12px;">
      @foreach ($chartSeries as $pt)
       @php
        $hOk = $pt['ok'] > 0 ? max(10, (int) round(($pt['ok'] / $maxG) * 140)) : 4;
        $hNo = $pt['no'] > 0 ? max(10, (int) round(($pt['no'] / $maxG) * 140)) : 4;
       @endphp
       <div style="display:flex;align-items:flex-end;gap:6px;">
        <i title="{{ $pt['label'] }} Disetujui: {{ $pt['ok'] }}" style="width:20px;height:{{ $hOk }}px;background:#07805d;"></i>
        <i title="{{ $pt['label'] }} Ditolak: {{ $pt['no'] }}" style="width:18px;height:{{ $hNo }}px;background:#f04462;"></i>
       </div>
      @endforeach
     </div>
     <div class="days" style="justify-content:space-around;">
      @foreach ($chartSeries as $pt)
       <span>{{ $pt['label'] }}</span>
      @endforeach
     </div>
    </div>
   </div>
  </div>
 </div>

 <div style="display:flex;justify-content:flex-end;gap:12px;flex-wrap:wrap;">
  <button type="button" class="btn" style="background:#07805d;" onclick="downloadCsv()"><span data-i="file-text"></span>Unduh Excel</button>
  <button type="button" class="btn" style="background:#f04462;" onclick="window.print()"><span data-i="file-down"></span>Unduh PDF</button>
 </div>

 {{-- Tabel tersembunyi/lengkap untuk ekspor CSV & detail siswa --}}
 <table id="rekapTable" style="display:none;">
  <thead><tr><th>NISN</th><th>Nama Siswa</th><th>Kelas</th><th>Total Laporan</th><th>Disetujui</th><th>Menunggu</th><th>Ditolak</th></tr></thead>
  <tbody>
   @foreach ($siswaList as $s)
    @php
     $total = $s->laporan->count();
     $ok = $s->laporan->where('status_verifikasi', true)->count();
     $rej = $s->laporan->where('status_verifikasi', false)->whereNotNull('id_guru_verifikator')->count();
     $wait = $total - $ok - $rej;
    @endphp
    <tr><td>{{ $s->nisn }}</td><td>{{ $s->nama_siswa }}</td><td>{{ $s->kelas->nama_kelas ?? '-' }}</td><td>{{ $total }}</td><td>{{ $ok }}</td><td>{{ $wait }}</td><td>{{ $rej }}</td></tr>
   @endforeach
  </tbody>
 </table>
</section>
@endsection

@push('scripts')
<script>
 paint();
 function downloadCsv() {
  var rows = [['NISN','Nama Siswa','Kelas','Total Laporan','Disetujui','Menunggu','Ditolak']];
  document.querySelectorAll('#rekapTable tbody tr').forEach(function (tr) {
   var cols = [...tr.querySelectorAll('td')].map(function (td) { return '"' + td.innerText.replace(/"/g, '""').trim() + '"'; });
   if (cols.length === 7) rows.push(cols);
  });
  var csv = rows.map(function (r) { return r.join(','); }).join('\n');
  var blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
  var a = document.createElement('a');
  a.href = URL.createObjectURL(blob);
  a.download = 'rekapitulasi-g7kaih.csv';
  a.click();
  toast('File CSV rekapitulasi berhasil diunduh.');
 }
</script>
@endpush
