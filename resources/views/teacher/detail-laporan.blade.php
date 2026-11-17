@extends('layout.teacher')
@section('title', 'Detail Laporan Siswa')

@section('content')
<section class="view on">
 <div class="top">
  <div>
   <h1>Detail Laporan</h1>
   <p class="sub">Tinjau laporan dan foto bukti sebelum menyetujui.</p>
  </div>
 </div>

 <div>
  <a href="{{ route('teacher.verifikasi') }}" style="color:var(--pri);font-size:12px;display:inline-flex;align-items:center;gap:6px;">&larr; Kembali ke Verifikasi Laporan</a>
 </div>

 @php
  $nama = $laporan->siswa->nama_siswa ?? '-';
  $ini = collect(preg_split('/\s+/', trim($nama)))->take(2)->map(fn($w)=>mb_strtoupper(mb_substr($w,0,1)))->join('');
  $lbl = $laporan->statusLabel();
 @endphp

 {{-- Card 1: Identitas Siswa & Tanggal (Figma 35:5685) --}}
 <div class="card" style="padding:20px;gap:14px;">
  <div style="display:flex;align-items:center;gap:14px;">
   <div class="av" style="width:56px;height:56px;font-size:18px;">{{ $ini }}</div>
   <div>
    <h2 style="font-size:18px;">{{ $nama }}</h2>
    <p class="ps">{{ $laporan->siswa->kelas->nama_kelas ?? '-' }} &middot; NIS {{ $laporan->siswa->nisn ?? '-' }}</p>
   </div>
  </div>
  <strong style="font-size:13px;">{{ $laporan->tanggal->translatedFormat('d F Y') }}</strong>
  <div>
   <span class="pill" style="border-radius:5px;background:{{ $lbl === 'Disetujui' ? 'var(--ok)' : ($lbl === 'Ditolak' ? 'var(--bad)' : 'var(--wait)') }}">
    {{ $lbl === 'Menunggu' ? 'Menunggu Verifikasi' : $lbl }}
   </span>
  </div>
 </div>

 {{-- Card 2: 7 Kebiasaan & Verifikasi (Figma 35:5693) --}}
 <div class="card" style="padding:20px;gap:16px;">
  <h2 style="font-size:16px;">7 Kebiasaan Anak Indonesia Hebat</h2>

  <div style="display:flex;flex-direction:column;gap:12px;font-size:13px;line-height:1.5;">
   @foreach ($laporan->details as $idx => $det)
    <div>{{ $idx + 1 }}. {{ $det->kebiasaan->nama_kebiasaan ?? '-' }} &mdash; {{ $det->keterangan ?: ($det->status ? 'Terlaksana' : 'Belum dilaksanakan') }}</div>
   @endforeach
  </div>

  <form method="POST" action="{{ route('teacher.verify', $laporan) }}" style="display:flex;flex-direction:column;gap:14px;padding-top:4px;">
   @csrf
   <div class="fld">
    <label for="catatan_gw">Catatan Guru Wali</label>
    <div class="ctl"><input id="catatan_gw" name="catatan" value="{{ old('catatan', $laporan->catatan) }}" placeholder="Tulis catatan verifikasi (opsional)..."></div>
   </div>
   <div style="display:flex;gap:12px;flex-wrap:wrap;">
    <button class="btn" type="submit" name="keputusan" value="setujui" style="background:var(--ok);">Setujui Laporan</button>
    <button class="btn" type="submit" name="keputusan" value="tolak" style="background:var(--bad);">Tolak Laporan</button>
   </div>
  </form>
 </div>
</section>
@endsection

@push('scripts')
<script>paint();</script>
@endpush
