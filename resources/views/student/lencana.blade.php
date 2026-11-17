@extends('layout.student')
@section('title', 'Lencana Pencapaian')

@section('content')
<h1 class="page-title">Lencana Pencapaian</h1>

<div class="lencana-summary">
  <span class="badge-card-icon" style="margin:0;width:48px;height:48px;background:var(--blue);">
    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>
  </span>
  <div>
    <div style="font-size:12px;color:var(--muted);">Koleksi Saya</div>
    <div style="font-size:20px;font-weight:700;color:var(--navy);">{{ $earnedMap->count() }} dari {{ $allBadges->count() }} Lencana</div>
  </div>
</div>

<div class="underline-tabs">
  <a class="underline-tab {{ $tab !== 'diraih' ? 'is-active' : '' }}" href="{{ route('student.lencana', ['tab' => 'semua']) }}">Semua Lencana</a>
  <a class="underline-tab {{ $tab === 'diraih' ? 'is-active' : '' }}" href="{{ route('student.lencana', ['tab' => 'diraih']) }}">Diraih ({{ $earnedMap->count() }})</a>
</div>

@php
  $colors = ['#1f6fd6', '#e34557', '#1890ff', '#07805d', '#f59e0b'];
@endphp

<div class="grid-3">
  @foreach ($allBadges as $i => $badge)
    @php
      $earned = $earnedMap->get($badge->id_badge);
      if ($tab === 'diraih' && ! $earned) continue;
    @endphp
    <article class="card">
      @if ($earned)
        <span class="badge-card-icon" style="background:{{ $colors[$i % count($colors)] }};">
          @if ($i % 3 === 0)
            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v8"/><path d="m4.93 10.93 1.41 1.41"/><path d="M2 18h2"/><path d="M20 18h2"/><path d="m19.07 10.93-1.41 1.41"/><path d="M22 22H2"/><path d="m8 6 4-4 4 4"/><path d="M16 18a4 4 0 0 0-8 0"/></svg>
          @elseif ($i % 3 === 1)
            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
          @else
            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
          @endif
        </span>
      @else
        <span class="badge-card-icon" style="background:#637792;">
          <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        </span>
      @endif

      <h2 class="card__title" style="margin-bottom:6px;">{{ $badge->nama }}</h2>
      <p style="font-size:12px;color:var(--muted);margin:0 0 14px;line-height:1.5;">{{ $badge->deskripsi }}</p>

      @if ($earned)
        <span class="status-pill status-pill--ok status-pill--round">Diraih pada {{ $earned->diperoleh_pada->translatedFormat('d M Y') }}</span>
      @else
        <div style="font-size:12px;color:var(--muted);margin-bottom:6px;">{{ $totalLaporan }} laporan ({{ $badge->syarat }})</div>
        <div class="progress-track" style="margin:0;">
          <div class="progress-fill" style="width:{{ $totalLaporan > 0 ? min(100, $totalLaporan * 10) : 0 }}%"></div>
        </div>
      @endif
    </article>
  @endforeach
</div>
@endsection
