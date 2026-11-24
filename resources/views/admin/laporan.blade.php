@extends('layout.admin')
@section('title', 'Pemantauan Keseluruhan')

@section('content')
<section class="view">
  <div class="top">
    <div>
      <h1>Pemantauan Seluruh Laporan</h1>
      <p class="sub">Pantau aktivitas pelaporan seluruh kelas di sekolah.</p>
    </div>
  </div>

  <form method="GET" action="{{ route('admin.laporan') }}" class="g3">
    <div class="fld">
      <label for="l_periode">Periode</label>
      <div class="ctl">
        <select id="l_periode" name="periode" onchange="this.form.submit()">
          <option value="">Semua Periode</option>
          <option value="harian" @selected($periode === 'harian')>Hari Ini</option>
          <option value="mingguan" @selected($periode === 'mingguan')>Mingguan</option>
          <option value="bulanan" @selected($periode === 'bulanan')>Bulanan</option>
        </select>
        <span data-i="chevron-down"></span>
      </div>
    </div>
    <div class="fld">
      <label for="l_tanggal">Tanggal</label>
      <div class="ctl">
        <input id="l_tanggal" type="date" name="tanggal" value="{{ $tanggal }}" onchange="this.form.submit()">
      </div>
    </div>
    <div class="fld">
      <label for="l_kelas">Kelas</label>
      <div class="ctl">
        <select id="l_kelas" name="id_kelas" onchange="this.form.submit()">
          <option value="">Semua Kelas</option>
          @foreach ($kelasList as $k)
            <option value="{{ $k->id_kelas }}" @selected((string) $idKelas === (string) $k->id_kelas)>{{ $k->nama_kelas }}</option>
          @endforeach
        </select>
        <span data-i="chevron-down"></span>
      </div>
    </div>
  </form>

  <div class="tier-grid">
    <div class="tier-card tier-card--ok" style="min-height:118px;">
      <div class="tier-card__top"><span>Disetujui</span><span class="tier-card__badge"><span data-i="circle-check"></span></span></div>
      <div><div class="tier-card__val">{{ $disetujui }}</div><div class="tier-card__sub">Dari {{ $totalLaporan }} laporan</div></div>
    </div>
    <div class="tier-card tier-card--wait" style="min-height:118px;">
      <div class="tier-card__top"><span>Menunggu Verifikasi</span><span class="tier-card__badge"><span data-i="hourglass"></span></span></div>
      <div><div class="tier-card__val">{{ $menunggu }}</div><div class="tier-card__sub">Menunggu guru wali</div></div>
    </div>
    <div class="tier-card tier-card--bad" style="min-height:118px;">
      <div class="tier-card__top"><span>Ditolak</span><span class="tier-card__badge"><span data-i="circle-x"></span></span></div>
      <div><div class="tier-card__val">{{ $ditolak }}</div><div class="tier-card__sub">Perlu perbaikan siswa</div></div>
    </div>
  </div>

  <div class="card sh">
    <h2>Daftar Laporan</h2>
    <div class="tinted-list">
      @forelse ($reports as $lap)
        @php
          $lbl = $lap->statusLabel();
          $tone = $lbl === 'Disetujui' ? 'ok' : ($lbl === 'Ditolak' ? 'bad' : 'wait');
          $nama = $lap->siswa->nama_siswa ?? 'Siswa';
          $ini = collect(preg_split('/\s+/', trim($nama)))->take(2)->map(fn($w)=>mb_strtoupper(mb_substr($w,0,1)))->join('');
        @endphp
        <div class="tinted-row tinted-row--{{ $tone }}">
          <div class="tinted-row__id">
            <span class="av" aria-hidden="true">{{ $ini }}</span>
            <div>
              <div class="tinted-row__name">{{ $nama }}</div>
              <div class="tinted-row__sub">{{ $lap->tanggal->translatedFormat('d M Y') }} &bull; {{ $lap->siswa->kelas->nama_kelas ?? '-' }}</div>
            </div>
          </div>
          <span class="pill pill--{{ $tone }}">{{ $lbl }}</span>
        </div>
      @empty
        <div style="text-align:center;color:var(--mut);padding:24px;">Belum ada laporan masuk di database.</div>
      @endforelse
    </div>
    {{ $reports->links() }}
  </div>

  <small style="color:var(--mut)">Data diperbarui terakhir pada {{ now()->translatedFormat('d F Y, H.i') }} WITA</small>
</section>
@endsection
