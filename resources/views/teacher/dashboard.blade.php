@extends('layout.teacher')
@section('title', 'Dashboard Guru Wali')

@section('content')
<section class="view on">
 <div class="top">
  <div><h1>Dashboard Guru Wali</h1><p class="sub">Pantau kebiasaan baik siswa di kelas perwalian Anda.</p></div>
 </div>

 {{-- Banner Kelas Perwalian (Figma 2:57636) --}}
 @php $kelasWali = $siswaList->first()?->kelas->nama_kelas ?? 'IX B'; @endphp
 <div class="card" style="flex-direction:row;align-items:center;justify-content:space-between;gap:16px;padding:18px 22px;">
  <div style="display:flex;align-items:center;gap:14px;">
   <span class="ib" style="width:44px;height:44px;border-radius:999px;"><span data-i="users-round"></span></span>
   <div>
    <h2 style="font-size:17px;">Kelas {{ $kelasWali }}</h2>
    <p class="ps">Jumlah Siswa: {{ $siswaList->count() }}</p>
   </div>
  </div>
  <a class="btn" href="{{ route('teacher.rekapitulasi') }}">Lihat Detail</a>
 </div>

 <div class="g2">
  <div class="card">
   <h2>Daftar Siswa Perwalian</h2>
   <div class="tw">
    <table>
     <thead><tr><th>No</th><th>Nama Siswa</th><th>Foto</th><th>NIS</th><th>Kelas</th></tr></thead>
     <tbody>
      @forelse ($siswaList as $idx => $s)
       @php $ini = collect(preg_split('/\s+/', trim($s->nama_siswa)))->take(2)->map(fn($w)=>mb_strtoupper(mb_substr($w,0,1)))->join(''); @endphp
       <tr>
        <td>{{ $idx + 1 }}</td>
        <td><a href="{{ route('teacher.detail-siswa', $s) }}" style="font-weight:600;color:var(--ink);">{{ $s->nama_siswa }}</a></td>
        <td><span class="av" style="width:32px;height:32px;font-size:11px;">{{ $ini }}</span></td>
        <td>{{ $s->nisn }}</td>
        <td>{{ $s->kelas->nama_kelas ?? '-' }}</td>
       </tr>
      @empty
       <tr><td colspan="5" style="text-align:center;color:var(--mut);padding:20px;">Belum ada siswa perwalian.</td></tr>
      @endforelse
     </tbody>
    </table>
   </div>
   <div style="padding-top:4px;">
    <a href="{{ route('teacher.rekapitulasi') }}" style="color:var(--pri);font-weight:600;font-size:12px;">Lihat Semua Siswa</a>
   </div>
  </div>

  <div style="display:flex;flex-direction:column;gap:18px;">
   <div class="card">
    <h2>Ringkasan Laporan</h2>
    <div style="display:flex;flex-direction:column;gap:16px;margin-top:6px;">
     <div style="display:flex;align-items:center;gap:12px;">
      <span class="c" style="width:38px;height:38px;border-radius:999px;background:#fff6e5;color:#b77913;display:grid;place-items:center;"><span data-i="hourglass"></span></span>
      <div><small style="color:var(--mut);display:block;font-size:11px;">Menunggu Verifikasi</small><b style="font-size:20px;color:#b77913;">{{ $menunggu }}</b></div>
     </div>
     <div style="display:flex;align-items:center;gap:12px;">
      <span class="c" style="width:38px;height:38px;border-radius:999px;background:#e9f6f1;color:#07805d;display:grid;place-items:center;"><span data-i="clipboard-check"></span></span>
      <div><small style="color:var(--mut);display:block;font-size:11px;">Disetujui</small><b style="font-size:20px;color:#07805d;">{{ $disetujui }}</b></div>
     </div>
     <div style="display:flex;align-items:center;gap:12px;">
      <span class="c" style="width:38px;height:38px;border-radius:999px;background:#fdecee;color:#e34557;display:grid;place-items:center;"><span data-i="circle-x"></span></span>
      <div><small style="color:var(--mut);display:block;font-size:11px;">Ditolak</small><b style="font-size:20px;color:#e34557;">{{ $ditolak }}</b></div>
     </div>
    </div>
   </div>

   <div class="card" style="background:var(--soft);border-color:transparent;">
    <h2>Ada {{ $menunggu }} laporan menunggu</h2>
    <p class="ps">Verifikasi laporan untuk mendukung perkembangan kebiasaan siswa.</p>
    <a class="btn" href="{{ route('teacher.verifikasi') }}" style="margin-top:6px;width:fit-content;"><span data-i="arrow-right"></span>Verifikasi Laporan</a>
   </div>
  </div>
 </div>
</section>
@endsection

@push('scripts')
<script>
 paint();
 @if (session('ok')) toast(@json(session('ok'))); @endif
</script>
@endpush
