@extends('layout.student')
@section('title', 'Beranda Siswa')

@section('content')
<h1 class="page-title">Selamat Datang</h1>

<div class="grid-beranda">
  <div class="list-stack" style="gap:24px;">
    {{-- Progres Laporan --}}
    <section class="card">
      <h2 class="card__title">Progres Laporan</h2>
      <div class="progress-meta">
        <span style="color:var(--muted);">{{ $periodeLabel }}</span>
        <strong style="color:var(--blue);">{{ $completedWeekCount }}/7 hari</strong>
      </div>
      <div class="progress-track">
        <div class="progress-fill" style="width:{{ round(($completedWeekCount / 7) * 100) }}%"></div>
      </div>
      <div class="week-circles">
        @foreach ($days as $day)
          <a class="week-item" href="{{ route('student.laporan', ['tanggal' => $day['date']]) }}" title="Isi laporan {{ $day['date'] }}">
            <span class="week-circle {{ $day['done'] ? 'is-done' : '' }}">{{ $day['dayNum'] }}</span>
            <span class="week-label">{{ $day['label'] }}</span>
          </a>
        @endforeach
      </div>
    </section>

    {{-- Riwayat Terbaru --}}
    <section class="card">
      <h2 class="card__title" style="margin-bottom:8px;">Riwayat Terbaru</h2>

      @if ($recentReports->isEmpty())
        <div class="alert alert--amber" style="margin:12px 0 0;">
          Belum ada laporan tersimpan. Mulai isi laporan 7 kebiasaan pertamamu hari ini!
        </div>
      @else
        @foreach ($recentReports as $lap)
          @php
            $lbl = $lap->statusLabel();
            $cls = match ($lbl) { 'Disetujui' => 'status-pill--ok', 'Ditolak' => 'status-pill--no', default => 'status-pill--wait' };
          @endphp
          <a class="history-row" href="{{ route('student.riwayat.detail', $lap) }}">
            <span class="history-row__left">
              <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="{{ $lbl === 'Disetujui' ? '#07805d' : '#5b6b80' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><path d="m9 15 2 2 4-4"/>
              </svg>
              <span>{{ $lap->tanggal->translatedFormat('l, d F Y') }}</span>
            </span>
            <span class="status-pill {{ $cls }}">{{ $lbl }}</span>
          </a>
        @endforeach

        <a class="history-more" href="{{ route('student.riwayat') }}">
          <span>Lihat Semua</span>
          <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
      @endif
    </section>
  </div>

  <div class="list-stack" style="gap:24px;">
    {{-- Lencana Terbaru --}}
    <section class="card" style="text-align:center;">
      <h2 class="card__title" style="text-align:left;">Lencana Terbaru</h2>
      @if ($earnedBadges->isNotEmpty())
        @php $latest = $earnedBadges->first(); @endphp
        <div class="badge-hero-icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 2v8"/><path d="m4.93 10.93 1.41 1.41"/><path d="M2 18h2"/><path d="M20 18h2"/><path d="m19.07 10.93-1.41 1.41"/><path d="M22 22H2"/><path d="m8 6 4-4 4 4"/><path d="M16 18a4 4 0 0 0-8 0"/>
          </svg>
        </div>
        <div style="font-size:17px;font-weight:700;color:var(--navy);">{{ $latest->badge->nama ?? 'Badge' }}</div>
        <div style="margin:8px 0 10px;">
          <span class="status-pill status-pill--ok status-pill--round">Diraih pada {{ $latest->diperoleh_pada->translatedFormat('d M Y') }}</span>
        </div>
        <p style="font-size:12px;color:var(--muted);margin:0;">{{ $latest->badge->deskripsi ?? '' }}</p>
      @else
        <p style="font-size:13px;color:var(--muted);margin:16px 0 0;">Belum ada lencana diraih.</p>
      @endif
    </section>

    {{-- Target Berikutnya --}}
    <section class="card">
      <h2 class="card__title" style="margin-bottom:14px;">Target Berikutnya</h2>
      @if ($nextBadge)
        <div style="font-size:14px;font-weight:600;color:var(--navy);">{{ $nextBadge->nama }}</div>
        <div style="font-size:12px;color:var(--muted);margin:6px 0 8px;">{{ $totalLaporan }} laporan tercatat ({{ $nextBadge->syarat }})</div>
        <div class="progress-track" style="margin-bottom:10px;">
          <div class="progress-fill" style="width:{{ $nextBadgePct }}%"></div>
        </div>
        <p style="font-size:12px;color:var(--muted);margin:0;">Terus isi laporan harianmu ya!</p>
      @else
        <div class="alert alert--ok" style="margin:0;">Semua lencana pencapaian telah diraih!</div>
      @endif
    </section>
  </div>
</div>

{{-- Banner Pencapaian Biru Penuh (Figma 543:7082) --}}
<a class="banner-lencana" href="{{ route('student.lencana') }}">
  <span class="banner-lencana__left">
    <span class="banner-lencana__icon" aria-hidden="true">
      <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>
    </span>
    <span>
      <span style="display:block;font-size:12px;opacity:.9;">Lencana Pencapaian</span>
      <span style="display:block;font-size:20px;font-weight:700;margin-top:2px;">{{ $earnedBadges->count() }} Lencana Diraih</span>
    </span>
  </span>
  <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
</a>

@if (session('badge_earned'))
  @php $be = session('badge_earned'); @endphp
  <div class="modal-backdrop is-open" id="badgeModal" role="dialog" aria-modal="true">
    <div class="modal-box" style="text-align:center;">
      <span class="status-pill status-pill--ok status-pill--round" style="margin-bottom:12px;">Lencana Baru Diraih!</span>
      <h3 class="modal-box__title">{{ $be['nama'] }}</h3>
      <p class="modal-box__text">{{ $be['deskripsi'] }} ({{ $be['syarat'] }})</p>
      <div class="modal-box__actions" style="justify-content:center;">
        <a class="btn btn--primary" href="{{ route('student.lencana') }}">Ke Laman Lencana</a>
        <button type="button" class="btn btn--secondary" onclick="document.getElementById('badgeModal').classList.remove('is-open')">Tutup</button>
      </div>
    </div>
  </div>
@endif
@endsection
