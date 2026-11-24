@extends('layout.teacher')
@section('title', 'Rekapitulasi Data Laporan')

@section('content')
@php
  $pctOk = $totalLaporan > 0 ? (int) round(($disetujui / $totalLaporan) * 100) : 0;
  $r = 34;
  $circ = round(2 * M_PI * $r, 2);
  $offset = round($circ * (1 - ($pctOk / 100)), 2);
@endphp

<section class="view">
  <div class="top">
    <div>
      <h1>Rekapitulasi Data Laporan</h1>
      <p class="sub">Ringkasan pelaporan dan perkembangan kebiasaan siswa kelas perwalian Anda.</p>
    </div>
  </div>

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
          <option value="">Semua Kelas Perwalian</option>
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
      <span class="ib"><span data-i="users-round"></span></span>
      <div><small>Total Siswa</small><b>{{ $totalSiswa }}</b></div>
    </div>
    <div>
      <span class="ib"><span data-i="clipboard-list"></span></span>
      <div><small>Total Laporan</small><b>{{ $totalLaporan }}</b></div>
    </div>
    <div style="background:var(--tier-ok);color:var(--tier-on-ok);border-color:transparent;">
      <span class="ib" style="background:rgba(255,255,255,.26);color:inherit;"><span data-i="circle-check"></span></span>
      <div><small style="color:inherit;opacity:.9;">Disetujui</small><b style="color:inherit;">{{ $disetujui }}</b></div>
    </div>
    <div style="background:var(--tier-bad);color:var(--tier-on-bad);border-color:transparent;">
      <span class="ib" style="background:rgba(255,255,255,.26);color:inherit;"><span data-i="circle-x"></span></span>
      <div><small style="color:inherit;opacity:.9;">Ditolak</small><b style="color:inherit;">{{ $ditolak }}</b></div>
    </div>
  </div>

  <div class="g2 eq">
    <div class="card sh">
      <h2>Rekap per Kelas</h2>
      <div class="tw">
        <table style="min-width:100%;">
          <thead><tr><th>Kelas</th><th>Total</th><th>Disetujui</th><th>Ditolak</th></tr></thead>
          <tbody>
            @forelse ($rekapKelas as $rk)
              <tr>
                <td><strong>{{ $rk['kelas'] }}</strong></td>
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
      <div class="top">
        <h2>Grafik Perkembangan</h2>
        <div style="display:flex;gap:12px;font-size:12px;color:var(--mut);">
          <span style="display:inline-flex;align-items:center;gap:5px;"><i style="width:10px;height:4px;border-radius:2px;background:var(--tier-ok);display:inline-block;"></i>Disetujui</span>
          <span style="display:inline-flex;align-items:center;gap:5px;"><i style="width:10px;height:4px;border-radius:2px;background:var(--tier-bad);display:inline-block;"></i>Ditolak</span>
        </div>
      </div>
      @php $maxG = max(1, collect($chartSeries)->max(fn($c) => max($c['ok'], $c['no']))); @endphp
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
                <i title="{{ $pt['label'] }} Disetujui: {{ $pt['ok'] }}" style="width:20px;height:{{ $hOk }}px;background:var(--tier-ok);"></i>
                <i title="{{ $pt['label'] }} Ditolak: {{ $pt['no'] }}" style="width:18px;height:{{ $hNo }}px;background:var(--tier-bad);"></i>
              </div>
            @endforeach
          </div>
          <div class="days" style="justify-content:space-around;">
            @foreach ($chartSeries as $pt)<span>{{ $pt['label'] }}</span>@endforeach
          </div>
        </div>
      </div>
      <div class="row" style="justify-content:space-between;padding-top:8px;border-top:1px solid var(--line-soft);">
        <div style="display:flex;align-items:center;gap:12px;">
          <svg width="84" height="84" viewBox="0 0 84 84" role="img" aria-label="Persentase persetujuan {{ $pctOk }}%">
            <circle cx="42" cy="42" r="{{ $r }}" fill="none" stroke="var(--line)" stroke-width="8"/>
            <circle cx="42" cy="42" r="{{ $r }}" fill="none" stroke="var(--tier-ok)" stroke-width="8" stroke-linecap="round"
                    stroke-dasharray="{{ $circ }}" stroke-dashoffset="{{ $offset }}" transform="rotate(-90 42 42)"/>
            <text x="42" y="47" text-anchor="middle" font-size="14" font-weight="700" fill="var(--ink)">{{ $pctOk }}%</text>
          </svg>
          <div>
            <strong style="display:block;font-size:13px;">Proporsi Verifikasi Disetujui</strong>
            <small style="color:var(--mut);">Disetujui {{ $disetujui }} &bull; Ditolak {{ $ditolak }}</small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div style="display:flex;justify-content:flex-end;gap:12px;flex-wrap:wrap;">
    <button type="button" class="btn ok" onclick="downloadCsv()"><span data-i="file-text"></span>Unduh Excel (.csv)</button>
    <button type="button" class="btn bad" onclick="window.print()"><span data-i="file-down"></span>Unduh PDF</button>
  </div>

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
    toast('File rekapitulasi berhasil diunduh.');
  }
</script>
@endpush
