@extends('layout.admin')
@section('title', 'Dashboard Admin')
@section('footer_note', 'Terakhir diperbarui pukul ' . now()->format('H.i') . ' WITA')

@section('content')
@php
  $r = 28;
  $circ = round(2 * M_PI * $r, 2);
  $dashOffset = round($circ * (1 - ($pctVerif / 100)), 2);
  $kelopakCols = ['#17B979', '#E34557', '#238CE2', '#EFBD37', '#34B6CA', '#2B64B7', '#31AA63'];
@endphp

<section class="view">
  <div class="top">
    <div>
      <h1>Dashboard Admin</h1>
      <p class="sub">SMPN 21 Sinjai &bull; Pantau pelaksanaan 7 Kebiasaan Anak Indonesia Hebat.</p>
    </div>
    <div class="date"><span data-i="calendar-days"></span>{{ now()->translatedFormat('l, d F Y') }}</div>
  </div>

  <div class="hero-band">
    <div class="hero-summary">
      <div class="hero-metric">
        <div>
          <div class="hero-metric__lbl">Verifikasi Sekolah</div>
          <div class="hero-metric__val">{{ $pctVerif }}%</div>
          <div class="hero-metric__sub">{{ $totalSiswa }} siswa &bull; {{ $totalGuru }} guru wali</div>
        </div>
        <svg width="70" height="70" viewBox="0 0 70 70" role="img" aria-label="Tingkat verifikasi sekolah {{ $pctVerif }}%">
          <circle cx="35" cy="35" r="{{ $r }}" fill="none" stroke="var(--line)" stroke-width="7"/>
          <circle cx="35" cy="35" r="{{ $r }}" fill="none" stroke="var(--tier-ok)" stroke-width="7" stroke-linecap="round"
                  stroke-dasharray="{{ $circ }}" stroke-dashoffset="{{ $dashOffset }}" transform="rotate(-90 35 35)"/>
          <text x="35" y="40" text-anchor="middle" font-size="13" font-weight="700" fill="var(--ink)">{{ round($pctVerif) }}%</text>
        </svg>
      </div>

      <div class="hero-metric">
        <div>
          <div class="hero-metric__lbl">Total Laporan</div>
          <div class="hero-metric__val">{{ $totalLaporan }}</div>
          <div class="hero-metric__sub">Perwalian {{ $perwalianTerisi }}/{{ $totalSiswa }} siswa</div>
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
      <a class="tier-card tier-card--ok" href="{{ route('admin.laporan', ['status' => 'disetujui']) }}">
        <div class="tier-card__top">
          <span>Disetujui</span>
          <span class="tier-card__badge"><span data-i="clipboard-check"></span></span>
        </div>
        <div>
          <div class="tier-card__val">{{ $terverifikasi }}</div>
          <div class="tier-card__sub">{{ $pctVerif }}% laporan</div>
        </div>
      </a>
      <a class="tier-card tier-card--wait" href="{{ route('admin.laporan', ['status' => 'menunggu']) }}">
        <div class="tier-card__top">
          <span>Menunggu</span>
          <span class="tier-card__badge"><span data-i="hourglass"></span></span>
        </div>
        <div>
          <div class="tier-card__val">{{ $menunggu }}</div>
          <div class="tier-card__sub">{{ $pctMenunggu }}% antrean</div>
        </div>
      </a>
      <a class="tier-card tier-card--bad" href="{{ route('admin.laporan', ['status' => 'ditolak']) }}">
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

  <div class="g2 eq">
    <div class="card sh">
      <div class="top">
        <div>
          <h2>Tren Pelaporan 7 Hari Terakhir</h2>
          <p class="ps">{{ now()->subDays(6)->translatedFormat('d') }}-{{ now()->translatedFormat('d F Y') }} &bull; Seluruh kelas</p>
        </div>
        <strong style="font-size:18px;">{{ $totalLaporan }} laporan</strong>
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
              <i class="{{ $loop->last ? 'hi' : '' }}" title="{{ $bar['label'] }}: {{ $bar['count'] }} laporan" style="height:{{ $bar['pct'] }}%"></i>
            @endforeach
          </div>
          <div class="days">
            @foreach ($trendBars as $bar)<span>{{ $bar['label'] }}</span>@endforeach
          </div>
        </div>
      </div>
    </div>

    <div class="card sh">
      <div class="top">
        <div>
          <h2>Distribusi Verifikasi per Kelas</h2>
          <p class="ps">Proporsi disetujui, menunggu, dan ditolak per kelas.</p>
        </div>
        <div style="display:flex;gap:10px;font-size:12px;color:var(--mut);">
          <span style="display:inline-flex;align-items:center;gap:4px;"><i style="width:10px;height:10px;border-radius:3px;background:var(--tier-ok);display:inline-block;"></i>OK</span>
          <span style="display:inline-flex;align-items:center;gap:4px;"><i style="width:10px;height:10px;border-radius:3px;background:var(--tier-wait);display:inline-block;"></i>Tunggu</span>
          <span style="display:inline-flex;align-items:center;gap:4px;"><i style="width:10px;height:10px;border-radius:3px;background:var(--tier-bad);display:inline-block;"></i>Tolak</span>
        </div>
      </div>
      <div class="habit-bars">
        @forelse ($kelasDistribusi as $kd)
          @php
            $t = max(1, $kd['total']);
            $wOk = $kd['total'] > 0 ? round(($kd['ok'] / $t) * 100, 1) : 0;
            $wWait = $kd['total'] > 0 ? round(($kd['wait'] / $t) * 100, 1) : 0;
            $wNo = $kd['total'] > 0 ? round(($kd['no'] / $t) * 100, 1) : 0;
          @endphp
          <div class="habit-bar-row" style="grid-template-columns:84px 1fr 44px;">
            <div class="habit-bar-row__lbl"><strong>{{ $kd['kelas'] }}</strong></div>
            <div class="stacked-track" title="{{ $kd['kelas'] }}: {{ $kd['ok'] }} disetujui, {{ $kd['wait'] }} menunggu, {{ $kd['no'] }} ditolak">
              @if ($wOk > 0)<div class="stacked-seg" style="width:{{ $wOk }}%;background:var(--tier-ok);"></div>@endif
              @if ($wWait > 0)<div class="stacked-seg" style="width:{{ $wWait }}%;background:var(--tier-wait);"></div>@endif
              @if ($wNo > 0)<div class="stacked-seg" style="width:{{ $wNo }}%;background:var(--tier-bad);"></div>@endif
            </div>
            <div class="habit-bar-row__pct">{{ $kd['pct'] }}%</div>
          </div>
        @empty
          <p class="ps">Belum ada data kelas.</p>
        @endforelse
      </div>
    </div>
  </div>

  <div class="g2">
    <div class="card sh">
      <div class="top">
        <h2>Aktivitas Pelaporan Terbaru</h2>
        <a href="{{ route('admin.laporan') }}" style="color:var(--pri);font-weight:600;font-size:13px;min-height:44px;display:inline-flex;align-items:center;">Lihat semua &rsaquo;</a>
      </div>
      <div class="tinted-list">
        @forelse ($recentLaporan as $lap)
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
                <div class="tinted-row__name">{{ $nama }} ({{ $lap->siswa->kelas->nama_kelas ?? '-' }})</div>
                <div class="tinted-row__sub">{{ $lap->tanggal->translatedFormat('d M Y') }} &bull; {{ $lap->catatan ?: 'Laporan 7 Kebiasaan' }}</div>
              </div>
            </div>
            <span class="pill pill--{{ $tone }}">{{ $lbl }}</span>
          </div>
        @empty
          <p class="ps">Belum ada laporan masuk.</p>
        @endforelse
      </div>
    </div>

    <div class="card sh">
      <h2>Akses Cepat Admin</h2>
      <div style="display:flex;flex-direction:column;gap:10px;">
        <a class="act" href="{{ route('akun.index') }}">
          <div class="c" style="background:var(--soft);color:var(--pri)"><span data-i="users-round"></span></div>
          <div>Kelola Akun &amp; Pengguna<small>Tambah dan atur akses guru &amp; siswa</small></div>
          <span data-i="chevron-right"></span>
        </a>
        <a class="act" href="{{ route('admin.perwalian') }}">
          <div class="c" style="background:var(--soft);color:var(--pri)"><span data-i="school"></span></div>
          <div>Atur Perwalian<small>Satu kelas, satu guru wali</small></div>
          <span data-i="chevron-right"></span>
        </a>
        <a class="act" href="{{ route('admin.badge') }}">
          <div class="c" style="background:var(--soft);color:var(--pri)"><span data-i="award"></span></div>
          <div>Badge Pencapaian<small>Kelola penghargaan kebiasaan siswa</small></div>
          <span data-i="chevron-right"></span>
        </a>
        <a class="act" href="{{ route('admin.laporan') }}">
          <div class="c" style="background:var(--soft);color:var(--pri)"><span data-i="chart-column"></span></div>
          <div>Pemantauan Keseluruhan<small>Tinjau seluruh laporan sekolah</small></div>
          <span data-i="chevron-right"></span>
        </a>
      </div>
    </div>
  </div>
</section>
@endsection
