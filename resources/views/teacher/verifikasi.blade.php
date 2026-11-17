@extends('layout.teacher')
@section('title', 'Verifikasi Laporan Siswa')

@section('content')
<section class="view on">
 <div class="top">
  <div><h1>Verifikasi Laporan Siswa</h1><p class="sub">Tinjau laporan dan foto bukti sebelum menyetujui.</p></div>
 </div>

 <div class="card sh">
  <form method="GET" action="{{ route('teacher.verifikasi') }}" class="g3">
   <div class="ctl">
    <select name="id_kelas" onchange="this.form.submit()" aria-label="Kelas">
     <option value="">Semua Kelas</option>
     @foreach ($kelasList as $k)
      <option value="{{ $k->id_kelas }}" @selected((string) $idKelas === (string) $k->id_kelas)>{{ $k->nama_kelas }}</option>
     @endforeach
    </select>
    <span data-i="chevron-down"></span>
   </div>
   <div class="ctl">
    <input type="date" name="tanggal" value="{{ $tanggal ?? '' }}" onchange="this.form.submit()" aria-label="Semua Tanggal">
   </div>
   <div class="ctl">
    <input type="search" name="q" value="{{ $search }}" placeholder="Cari nama siswa...">
    <span data-i="search"></span>
   </div>
  </form>

  <div class="tw">
   <table>
    <thead><tr><th>No</th><th>Tanggal</th><th>Nama Siswa</th><th>Foto</th><th>Kelas</th><th>Foto Bukti</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
     @forelse ($reports as $lap)
      @php
       $lbl = $lap->statusLabel();
       $nama = $lap->siswa->nama_siswa ?? '-';
       $inisial = collect(preg_split('/\s+/', trim($nama)))->take(2)->map(fn($w)=>mb_strtoupper(mb_substr($w,0,1)))->join('');
      @endphp
      <tr>
       <td style="color:var(--mut)">{{ $reports->firstItem() + $loop->index }}</td>
       <td>{{ $lap->tanggal->translatedFormat('d M Y') }}</td>
       <td><strong>{{ $nama }}</strong></td>
       <td><span class="av" style="width:32px;height:32px;font-size:11px;">{{ $inisial }}</span></td>
       <td>{{ $lap->siswa->kelas->nama_kelas ?? '-' }}</td>
       <td><a href="{{ route('teacher.detail-laporan', $lap) }}" style="color:var(--pri);font-weight:500;">Lihat foto bukti</a></td>
       <td>
        <span class="pill" style="background:{{ $lbl === 'Disetujui' ? '#07805d' : ($lbl === 'Ditolak' ? '#c52d49' : '#94a3b8') }}">
         {{ $lbl }}
        </span>
       </td>
       <td>
        <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
         @if ($lbl === 'Menunggu')
          <form method="POST" action="{{ route('teacher.verify', $lap) }}" style="margin:0;">
           @csrf
           <input type="hidden" name="keputusan" value="setujui">
           <button type="submit" class="btn s" style="background:#07805d;">Setujui</button>
          </form>
          <form method="POST" action="{{ route('teacher.verify', $lap) }}" style="margin:0;">
           @csrf
           <input type="hidden" name="keputusan" value="tolak">
           <button type="submit" class="btn s" style="background:#c52d49;">Tolak</button>
          </form>
         @endif
         <a class="btn s" href="{{ route('teacher.detail-laporan', $lap) }}">Detail</a>
        </div>
       </td>
      </tr>
     @empty
      <tr><td colspan="8" style="text-align:center;color:var(--mut);padding:24px;">Tidak ada laporan.</td></tr>
     @endforelse
    </tbody>
   </table>
  </div>

  <div class="row" style="align-items:center;justify-content:space-between;">
   <small style="color:var(--mut)">Menampilkan {{ $reports->firstItem() ?? 0 }}&ndash;{{ $reports->lastItem() ?? 0 }} dari {{ $reports->total() }} laporan</small>
   {{ $reports->links() }}
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
