@extends('layout.student')
@section('title', 'Detail Riwayat Laporan')

@section('content')
<div class="page-head" style="margin-bottom:20px;">
  <div>
    <a class="auth-link" style="font-size:13px;display:inline-flex;align-items:center;gap:6px;" href="{{ route('student.riwayat') }}">&larr; Kembali ke Semua riwayat</a>
    <h1 class="page-head__title" style="margin-top:8px;">Detail Riwayat Laporan</h1>
  </div>
</div>

@php
  $lbl = $laporan->statusLabel();
  $cls = match ($lbl) { 'Disetujui' => 'status-pill--ok', 'Ditolak' => 'status-pill--no', default => 'status-pill--wait' };
@endphp

<div class="grid-laporan">
  <section class="card">
    <h2 class="card__title" style="margin-bottom:18px;">{{ $laporan->tanggal->translatedFormat('d F Y') }}</h2>
    <div class="list-stack" style="gap:16px;">
      @foreach ($laporan->details as $idx => $det)
        <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;padding:6px 0;">
          <span class="habit-check-row__title">
            <span style="width:32px;height:32px;border-radius:8px;background:var(--blue-soft);color:var(--blue);display:inline-flex;align-items:center;justify-content:center;flex:none;">
              @if ($idx === 0)
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v8"/><path d="m4.93 10.93 1.41 1.41"/><path d="M2 18h2"/><path d="M20 18h2"/><path d="m19.07 10.93-1.41 1.41"/><path d="M22 22H2"/><path d="m8 6 4-4 4 4"/><path d="M16 18a4 4 0 0 0-8 0"/></svg>
              @elseif ($idx === 1)
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
              @elseif ($idx === 2)
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18.5" cy="17.5" r="3.5"/><circle cx="5.5" cy="17.5" r="3.5"/><circle cx="15" cy="5" r="1"/><path d="M12 17.5V14l-3-3 4-3 2 3h2"/></svg>
              @elseif ($idx === 3)
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/><path d="M7 2v20"/><path d="M21 15V2v0a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Zm0 0v7"/></svg>
              @elseif ($idx === 4)
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
              @elseif ($idx === 5)
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
              @else
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
              @endif
            </span>
            <span>{{ $det->kebiasaan->nama_kebiasaan ?? '-' }}</span>
          </span>
          @if ($idx === 0 || $idx === $laporan->details->count() - 1)
            <strong style="font-size:16px;color:var(--navy);">{{ $det->keterangan ?: '-' }}</strong>
          @else
            <span class="habit-check-pill" style="cursor:default;">
              <input type="checkbox" disabled @checked($det->status)>
              <span>Terlaksana</span>
            </span>
          @endif
        </div>
        @if ($idx > 0 && $idx < $laporan->details->count() - 1 && ! in_array($det->keterangan, ['', null, 'Terlaksana', 'Belum dilaksanakan'], true))
          <div style="padding-left:44px;margin-top:-6px;">
            <div style="font-size:12px;color:var(--muted);margin-bottom:4px;">Catatan</div>
            <div style="min-height:40px;padding:9px 12px;border-radius:6px;border:1px solid var(--line);background:var(--card);font-size:13px;color:var(--navy);max-width:532px;">
              {{ $det->keterangan }}
            </div>
          </div>
        @endif
      @endforeach
    </div>
  </section>

  <section class="card" style="height:fit-content;">
    <h2 class="card__title" style="margin-bottom:12px;">Status laporan</h2>
    <div style="padding-bottom:14px;border-bottom:1px solid var(--line-soft);margin-bottom:14px;">
      <span class="status-pill {{ $cls }}">{{ $lbl }}</span>
    </div>
    <div style="padding-bottom:14px;border-bottom:1px solid var(--line-soft);margin-bottom:14px;">
      <div style="font-size:12px;color:var(--muted);margin-bottom:4px;">Guru wali</div>
      <div style="font-size:14px;font-weight:700;color:var(--navy);">{{ $laporan->guruVerifikator->nama_guru ?? $siswa->guruWali->nama_guru ?? 'Menunggu verifikasi' }}</div>
    </div>
    <div>
      <div style="font-size:12px;color:var(--muted);margin-bottom:8px;">Catatan Guru Wali</div>
      <div style="padding:12px 14px;border-radius:8px;background:var(--card);border:1px solid var(--line);font-size:13px;line-height:1.5;color:var(--navy);">
        {{ $laporan->catatan ?: 'Belum ada catatan tambahan.' }}
      </div>
    </div>
  </section>
</div>
@endsection
