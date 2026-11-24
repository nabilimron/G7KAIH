@extends('layout.teacher')
@section('title', 'Dashboard Guru Wali')

@section('content')
@php
  $kelasWali = $siswaList->first()?->kelas->nama_kelas ?? '-';
  $pctOkBar = $totalLaporan > 0 ? round(($disetujui / $totalLaporan) * 100, 1) : 0;
  $r = 28;
  $circ = round(2 * M_PI * $r, 2);
  $dashOffset = round($circ * (1 - ($pctVerif / 100)), 2);
  $kelopakCols = ['#17B979', '#E34557', '#238CE2', '#EFBD37', '#34B6CA', '#2B64B7', '#31AA63'];
@endphp

<section class="view">
  <div class="top">
    <div>
      <h1>Dashboard Guru Wali</h1>
      <p class="sub">Kelas {{ $kelasWali }} &bull; Wali: {{ $guru->nama_guru ?? ($user->name ?? 'Guru Wali') }}</p>
    </div>
    <div class="ctx-group">
      <div class="avatar-stack" aria-hidden="true">
        @foreach ($siswaList->take(4) as $s)
          @php $ini = collect(preg_split('/\s+/', trim($s->nama_siswa)))->take(2)->map(fn($w)=>mb_strtoupper(mb_substr($w,0,1)))->join(''); @endphp
          <span class="av">{{ $ini }}</span>
        @endforeach
      </div>
      <a class="alert-pill" href="{{ route('teacher.verifikasi', ['status' => 'menunggu']) }}">
        <span data-i="hourglass"></span>
        <span>{{ $menunggu }} Menunggu Verifikasi</span>
      </a>
    </div>
  </div>

  <div class="hero-band">
    <div class="hero-summary">
      <div class="hero-metric">
        <div>
          <div class="hero-metric__lbl">Tingkat Verifikasi</div>
          <div class="hero-metric__val">{{ $pctVerif }}%</div>
          <div class="hero-metric__sub">{{ $disetujui }} dari {{ $totalLaporan }} laporan</div>
        </div>
        <svg width="70" height="70" viewBox="0 0 70 70" role="img" aria-label="Tingkat verifikasi {{ $pctVerif }}%">
          <circle cx="35" cy="35" r="{{ $r }}" fill="none" stroke="var(--line)" stroke-width="7"/>
          <circle cx="35" cy="35" r="{{ $r }}" fill="none" stroke="var(--tier-ok)" stroke-width="7" stroke-linecap="round"
                  stroke-dasharray="{{ $circ }}" stroke-dashoffset="{{ $dashOffset }}" transform="rotate(-90 35 35)"/>
          <text x="35" y="40" text-anchor="middle" font-size="13" font-weight="700" fill="var(--ink)">{{ $pctVerif }}%</text>
        </svg>
      </div>

      <div class="hero-metric">
        <div>
          <div class="hero-metric__lbl">Total Laporan</div>
          <div class="hero-metric__val">{{ $totalLaporan }}</div>
          <div class="hero-metric__sub">{{ $siswaList->count() }} siswa perwalian</div>
        </div>
        <div class="kelopak-ring" aria-hidden="true">
          @foreach ($kelopakCols as $idx => $col)
            @php
              $ang = ($idx * (360 / 7) - 90) * M_PI / 180;
              $lx = round(25 + cos($ang) * 21, 1);
              $ly = round(25 + sin($ang) * 21, 1);
            @endphp
            <span style="left:{{ $lx }}px;top:{{ $ly }}px;background:{{ $col }};"></span>
          @endforeach
        </div>
      </div>
    </div>

    <div class="tier-grid">
      <a class="tier-card tier-card--ok" href="{{ route('teacher.verifikasi', ['status' => 'disetujui']) }}">
        <div class="tier-card__top">
          <span>Disetujui</span>
          <span class="tier-card__badge"><span data-i="clipboard-check"></span></span>
        </div>
        <div>
          <div class="tier-card__val">{{ $disetujui }}</div>
          <div class="tier-card__sub">{{ $pctOkBar }}% laporan</div>
        </div>
      </a>
      <a class="tier-card tier-card--wait" href="{{ route('teacher.verifikasi', ['status' => 'menunggu']) }}">
        <div class="tier-card__top">
          <span>Menunggu</span>
          <span class="tier-card__badge"><span data-i="hourglass"></span></span>
        </div>
        <div>
          <div class="tier-card__val">{{ $menunggu }}</div>
          <div class="tier-card__sub">{{ $pctMenunggu }}% antrean</div>
        </div>
      </a>
      <a class="tier-card tier-card--bad" href="{{ route('teacher.verifikasi', ['status' => 'ditolak']) }}">
        <div class="tier-card__top">
          <span>Ditolak</span>
          <span class="tier-card__badge"><span data-i="circle-x"></span></span>
        </div>
        <div>
          <div class="tier-card__val">{{ $ditolak }}</div>
          <div class="tier-card__sub">{{ $pctDitolak }}% revisi</div>
        </div>
      </a>
    </div>
  </div>

  <div class="card sh">
    <div class="top">
      <div>
        <h2>Kepatuhan 7 Kebiasaan Kelas {{ $kelasWali }}</h2>
        <p class="ps">Persentase keterlaksanaan setiap kebiasaan berdasarkan {{ $totalLaporan }} laporan siswa.</p>
      </div>
      <a class="btn o s" href="{{ route('teacher.rekapitulasi') }}"><span data-i="chart-column"></span>Rekapitulasi</a>
    </div>
    <div class="habit-bars">
      @forelse ($habitStats as $hb)
        <div class="habit-bar-row">
          <div class="habit-bar-row__lbl">{{ $hb['nama'] }}</div>
          <div class="habit-bar-row__trk" role="progressbar" aria-valuenow="{{ $hb['pct'] }}" aria-valuemin="0" aria-valuemax="100" aria-label="{{ $hb['nama'] }}">
            <div class="habit-bar-row__fill" style="width:{{ max(4, $hb['pct']) }}%;background:{{ $hb['color'] }};"></div>
          </div>
          <div class="habit-bar-row__pct">{{ $hb['pct'] }}%</div>
        </div>
      @empty
        <p class="ps">Belum ada data detail kebiasaan.</p>
      @endforelse
    </div>
  </div>

  <div class="card sh">
    <div class="top">
      <div>
        <h2>Daftar Siswa Perwalian (Kelas {{ $kelasWali }})</h2>
        <p class="ps">Klik nama atau detail untuk melihat riwayat kebiasaan dan lencana siswa.</p>
      </div>
      <a href="{{ route('teacher.rekapitulasi') }}" style="color:var(--pri);font-weight:600;font-size:13px;min-height:44px;display:inline-flex;align-items:center;">Lihat Semua Siswa &rsaquo;</a>
    </div>

    <div class="tinted-list">
      @forelse ($siswaList as $s)
        @php
          $ini = collect(preg_split('/\s+/', trim($s->nama_siswa)))->take(2)->map(fn($w)=>mb_strtoupper(mb_substr($w,0,1)))->join('');
          $totS = (int) ($s->total_laporan_count ?? 0);
          $okS = (int) ($s->disetujui_count ?? 0);
          $waitS = (int) ($s->menunggu_count ?? 0);
          $noS = (int) ($s->ditolak_count ?? 0);
          $pctS = $totS > 0 ? (int) round(($okS / $totS) * 100) : 0;
          $tone = $pctS >= 75 ? 'ok' : ($pctS >= 45 || $waitS > 0 ? 'wait' : 'bad');
          $barCol = $tone === 'ok' ? 'var(--tier-ok)' : ($tone === 'wait' ? 'var(--tier-wait)' : 'var(--tier-bad)');
        @endphp
        <div class="tinted-row tinted-row--{{ $tone }}">
          <div class="tinted-row__id">
            <span class="av" aria-hidden="true">{{ $ini }}</span>
            <div>
              <div class="tinted-row__name"><a href="{{ route('teacher.detail-siswa', $s) }}">{{ $s->nama_siswa }}</a></div>
              <div class="tinted-row__sub">NIS {{ $s->nisn }} &bull; {{ $s->kelas->nama_kelas ?? '-' }}</div>
            </div>
          </div>

          <div style="font-size:13px;font-weight:600;color:var(--ink);">{{ $okS }} / {{ $totS }} disetujui</div>

          <div class="prog-track">
            <div class="prog-track__bar">
              <div class="prog-track__fill" style="width:{{ max(6, $pctS) }}%;background:{{ $barCol }};"></div>
            </div>
            <span class="prog-track__pct">{{ $pctS }}%</span>
          </div>

          <div class="bubble-group" aria-label="Ringkasan status {{ $s->nama_siswa }}">
            <span class="bubble bubble--ok" title="Disetujui">{{ $okS }}</span>
            <span class="bubble bubble--wait" title="Menunggu">{{ $waitS }}</span>
            <span class="bubble bubble--bad" title="Ditolak">{{ $noS }}</span>
          </div>

          <a class="btn o s" href="{{ route('teacher.detail-siswa', $s) }}">Detail</a>
        </div>
      @empty
        <div style="text-align:center;color:var(--mut);padding:24px;">Belum ada siswa perwalian.</div>
      @endforelse
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
  @if (session('ok')) toast(@json(session('ok'))); @endif
</script>
@endpush
