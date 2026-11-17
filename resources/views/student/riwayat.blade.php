@extends('layout.student')
@section('title', 'Riwayat Laporan')

@section('content')
<h1 class="page-title">Riwayat Laporan</h1>

<section class="card">
  <form method="GET" style="display:flex;justify-content:flex-end;margin-bottom:18px;">
    <div class="input-wrap" style="width:100%;max-width:320px;background:var(--bg);border-radius:8px;">
      <span class="input-wrap__icon" aria-hidden="true">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
      </span>
      <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari tanggal atau status" aria-label="Cari tanggal atau status">
    </div>
  </form>

  <div class="table-wrap">
    <table class="tbl">
      <thead>
        <tr>
          <th style="width:192px;">Tanggal</th>
          <th style="width:151px;">Status</th>
          <th>Catatan terakhir</th>
          <th style="width:120px;text-align:right;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($reports as $lap)
          @php
            $lbl = $lap->statusLabel();
            $cls = match ($lbl) { 'Disetujui' => 'status-pill--ok', 'Ditolak' => 'status-pill--no', default => 'status-pill--wait' };
          @endphp
          <tr>
            <td><strong>{{ $lap->tanggal->translatedFormat('d F Y') }}</strong></td>
            <td><span class="status-pill {{ $cls }}">{{ $lbl }}</span></td>
            <td style="color:var(--navy);">{{ $lap->catatan ?: '-' }}</td>
            <td style="text-align:right;">
              <a class="auth-link" style="font-size:12px;display:inline-flex;align-items:center;gap:4px;" href="{{ route('student.riwayat.detail', $lap) }}">
                Lihat detail
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
              </a>
            </td>
          </tr>
        @empty
          <tr><td colspan="4" style="text-align:center;color:var(--muted);padding:28px;">Belum ada riwayat laporan.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div style="margin-top:16px;">
    {{ $reports->links() }}
  </div>
</section>
@endsection
