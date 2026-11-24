@extends('layout.teacher')
@section('title', 'Detail Laporan Siswa')

@section('content')
@php
  $nama = $laporan->siswa->nama_siswa ?? '-';
  $ini = collect(preg_split('/\s+/', trim($nama)))->take(2)->map(fn($w)=>mb_strtoupper(mb_substr($w,0,1)))->join('');
  $lbl = $laporan->statusLabel();
  $tone = $lbl === 'Disetujui' ? 'ok' : ($lbl === 'Ditolak' ? 'bad' : 'wait');
@endphp

<section class="view">
  <div class="top">
    <div>
      <h1>Detail Laporan</h1>
      <p class="sub">Tinjau rincian 7 kebiasaan dan foto bukti sebelum menyetujui atau menolak.</p>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap;">
      <button type="button" class="btn o s" onclick="openOverlay('photoProofModal', this)"><span data-i="camera"></span>Lihat Foto Bukti</button>
      <a class="btn o s" href="{{ route('teacher.verifikasi') }}">&larr; Kembali ke Verifikasi</a>
    </div>
  </div>

  <div class="card sh">
    <div style="display:flex;align-items:center;justify-content:space-between;gap:14px;flex-wrap:wrap;">
      <div style="display:flex;align-items:center;gap:14px;">
        <div class="av" style="width:52px;height:52px;font-size:16px;">{{ $ini }}</div>
        <div>
          <h2>{{ $nama }}</h2>
          <p class="ps">{{ $laporan->siswa->kelas->nama_kelas ?? '-' }} &bull; NIS {{ $laporan->siswa->nisn ?? '-' }}</p>
        </div>
      </div>
      <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
        <strong style="font-size:13px;">{{ $laporan->tanggal->translatedFormat('d F Y') }}</strong>
        <span class="pill pill--{{ $tone }}">{{ $lbl === 'Menunggu' ? 'Menunggu Verifikasi' : $lbl }}</span>
      </div>
    </div>
  </div>

  <div class="card sh">
    <h2>7 Kebiasaan Anak Indonesia Hebat</h2>

    <div class="tinted-list">
      @foreach ($laporan->details as $idx => $det)
        @php
          $kebName = $det->kebiasaan->nama_kebiasaan ?? '-';
          $timeValidNote = null;
          $pillTone = $det->status ? 'ok' : 'wait';
          $pillLabel = $det->status ? 'Terlaksana' : 'Belum';
          if (preg_match('/(\d{2})[:.](\d{2})/', (string) $det->keterangan, $tm)) {
              $mins = ((int) $tm[1]) * 60 + (int) $tm[2];
              if (str_contains(mb_strtolower($kebName), 'bangun')) {
                  $onTime = $mins >= 240 && $mins <= 360;
                  $pillTone = $onTime ? 'ok' : 'bad';
                  $pillLabel = $onTime ? 'Tepat Waktu' : 'Di Luar Jadwal';
                  $timeValidNote = 'Standar bangun: 04.00 - 06.00 WITA';
              } elseif (str_contains(mb_strtolower($kebName), 'tidur')) {
                  $onTime = $mins >= 1200 && $mins <= 1320;
                  $pillTone = $onTime ? 'ok' : 'wait';
                  $pillLabel = $onTime ? 'Tepat Waktu' : 'Di Luar Jadwal';
                  $timeValidNote = 'Standar tidur: 20.00 - 22.00 WITA';
              }
          }
        @endphp
        <div class="tinted-row tinted-row--{{ $pillTone === 'bad' ? 'bad' : ($det->status ? 'ok' : 'soft') }}">
          <div>
            <div class="tinted-row__name">{{ $idx + 1 }}. {{ $kebName }}</div>
            <div class="tinted-row__sub">
              {{ $det->keterangan ?: ($det->status ? 'Terlaksana' : 'Belum dilaksanakan') }}
              @if ($timeValidNote) &bull; {{ $timeValidNote }} @endif
            </div>
          </div>
          <span class="pill pill--{{ $pillTone }}">{{ $pillLabel }}</span>
        </div>
      @endforeach
    </div>

    <form method="POST" action="{{ route('teacher.verify', $laporan) }}" style="display:flex;flex-direction:column;gap:14px;padding-top:4px;">
      @csrf
      <div class="fld">
        <label for="catatan_gw">Catatan Guru Wali</label>
        <div class="ctl"><input id="catatan_gw" name="catatan" value="{{ old('catatan', $laporan->catatan) }}" placeholder="Tulis catatan verifikasi (opsional)..."></div>
      </div>
      <div style="display:flex;gap:12px;flex-wrap:wrap;">
        <button class="btn ok" type="submit" name="keputusan" value="setujui"><span data-i="circle-check"></span>Setujui Laporan</button>
        <button class="btn bad" type="submit" name="keputusan" value="tolak"><span data-i="circle-x"></span>Tolak Laporan</button>
      </div>
    </form>
  </div>
</section>

<div id="photoProofModal" class="modal-backdrop" role="dialog" aria-modal="true" aria-labelledby="proofTitle" onclick="if(event.target===this)closeOverlay('photoProofModal')">
  <div class="card" style="width:100%;max-width:480px;">
    <div class="row" style="justify-content:space-between;">
      <h2 id="proofTitle">Pratinjau Foto Bukti</h2>
      <button type="button" class="btn o s" onclick="closeOverlay('photoProofModal')">Tutup</button>
    </div>
    <div style="background:var(--card-2);border:1px solid var(--line);border-radius:12px;padding:36px 20px;text-align:center;display:flex;flex-direction:column;align-items:center;gap:8px;">
      <span data-i="camera" style="font-size:32px;color:var(--mut);"></span>
      <strong>{{ $nama }} &bull; {{ $laporan->tanggal->translatedFormat('d M Y') }}</strong>
      <small style="color:var(--mut);">Lampiran foto bukti mengikuti kolom penyimpanan laporan di db_g7kaih.</small>
    </div>
  </div>
</div>
@endsection
