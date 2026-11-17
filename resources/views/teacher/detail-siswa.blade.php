@extends('layout.teacher')
@section('title', 'Detail Siswa')

@section('content')
<section class="view on">
 <div class="top">
  <div>
   <h1>Detail Siswa</h1>
   <p class="sub">Pantau laporan dan pencapaian siswa perwalian.</p>
  </div>
 </div>

 <div>
  <a href="{{ route('teacher.dashboard') }}" style="color:var(--pri);font-size:12px;display:inline-flex;align-items:center;gap:6px;">&larr; Kembali ke Daftar Siswa</a>
 </div>

 @php
  $ini = collect(preg_split('/\s+/', trim($siswa->nama_siswa)))->take(2)->map(fn($w)=>mb_strtoupper(mb_substr($w,0,1)))->join('');
  $approvedCount = $siswa->laporan->where('status_verifikasi', true)->count();
  $earnedBadges = $siswa->badgeSiswa;
  $badgeNames = $earnedBadges->map(fn($bs) => $bs->badge->nama ?? '')->filter()->join(' · ');
 @endphp

 {{-- Card 1: Identitas Siswa (Figma 35:5609) --}}
 <div class="card" style="padding:20px;gap:14px;">
  <div style="display:flex;align-items:center;gap:14px;">
   <div class="av" style="width:56px;height:56px;font-size:18px;">{{ $ini }}</div>
   <div>
    <h2 style="font-size:18px;">{{ $siswa->nama_siswa }}</h2>
    <p class="ps">{{ $siswa->kelas->nama_kelas ?? '-' }} &middot; NIS {{ $siswa->nisn }}</p>
   </div>
  </div>
  <p style="font-size:13px;color:var(--mut);">Guru Wali: {{ $siswa->guruWali->nama_guru ?? $guru->nama_guru }} &middot; Tahun ajaran {{ $semester->tahun_ajaran ?? '2026 / 2027' }}</p>
  <div>
   <span class="pill" style="background:var(--ok);border-radius:5px;">Aktif</span>
  </div>
 </div>

 {{-- Card 2: Ringkasan 2 Kolom (Figma 35:5617) --}}
 <div class="g2 eq">
  <div class="card" style="padding:20px;gap:12px;">
   <h2 style="font-size:16px;">Laporan disetujui</h2>
   <b style="font-size:28px;">{{ $approvedCount }} laporan</b>
   <p style="font-size:13px;color:var(--mut);">
    @if ($nextBadge)
     Kemajuan {{ $nextBadge->nama }}: {{ $siswa->laporan->count() }} ({{ $nextBadge->syarat }})
    @else
     Semua badge pencapaian telah diraih.
    @endif
   </p>
  </div>
  <div class="card" style="padding:20px;gap:12px;">
   <h2 style="font-size:16px;">Badge pencapaian</h2>
   <b style="font-size:28px;">{{ $earnedBadges->count() }} dari {{ $totalBadgeMaster }} Badge</b>
   <p style="font-size:13px;color:var(--mut);">{{ $badgeNames ?: 'Belum ada badge diraih.' }}</p>
  </div>
 </div>

 {{-- Card 3: Riwayat Laporan (Figma 35:5626) --}}
 <div class="card" style="padding:20px;gap:12px;">
  <h2 style="font-size:16px;">Riwayat Laporan</h2>
  @forelse ($siswa->laporan as $lap)
   @php $lbl = $lap->statusLabel(); @endphp
   <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;padding:12px 0;border-bottom:1px solid var(--line);">
    <div style="display:flex;flex-direction:column;gap:4px;font-size:13px;">
     <strong>{{ $lap->tanggal->translatedFormat('d M Y') }}</strong>
     <span style="color:var(--mut);">{{ $lap->details->count() }} kebiasaan dilaporkan</span>
     <a href="{{ route('teacher.detail-laporan', $lap) }}" style="color:var(--pri);font-weight:500;">Lihat foto bukti</a>
    </div>
    <span class="pill" style="border-radius:5px;background:{{ $lbl === 'Disetujui' ? 'var(--ok)' : ($lbl === 'Ditolak' ? 'var(--bad)' : 'var(--wait)') }}">{{ $lbl }}</span>
   </div>
  @empty
   <p style="color:var(--mut);font-size:13px;padding:12px 0;">Belum ada riwayat laporan untuk siswa ini.</p>
  @endforelse
 </div>
</section>
@endsection

@push('scripts')
<script>paint();</script>
@endpush
