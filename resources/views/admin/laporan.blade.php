@extends('layout.admin')
@section('title', 'Pemantauan Keseluruhan')

@section('content')
<section class="view on">
 <div class="top">
  <div><h1>Pemantauan Seluruh Laporan</h1><p class="sub">Pantau aktivitas pelaporan seluruh kelas di sekolah.</p></div>
 </div>

 <form method="GET" action="{{ route('admin.laporan') }}" class="g3">
  <div class="fld">
   <label for="l_periode">Periode</label>
   <div class="ctl">
    <select id="l_periode" name="periode" onchange="this.form.submit()">
     <option value="">Harian</option>
     <option value="harian" @selected($periode === 'harian')>Hari Ini</option>
     <option value="mingguan" @selected($periode === 'mingguan')>Mingguan</option>
     <option value="bulanan" @selected($periode === 'bulanan')>Bulanan</option>
    </select>
    <span data-i="chevron-down"></span>
   </div>
  </div>
  <div class="fld">
   <label for="l_tanggal">Tanggal</label>
   <div class="ctl">
    <input id="l_tanggal" type="date" name="tanggal" value="{{ $tanggal }}" onchange="this.form.submit()">
   </div>
  </div>
  <div class="fld">
   <label for="l_kelas">Kelas</label>
   <div class="ctl">
    <select id="l_kelas" name="id_kelas" onchange="this.form.submit()">
     <option value="">Semua Kelas</option>
     @foreach ($kelasList as $k)
      <option value="{{ $k->id_kelas }}" @selected((string) $idKelas === (string) $k->id_kelas)>{{ $k->nama_kelas }}</option>
     @endforeach
    </select>
    <span data-i="chevron-down"></span>
   </div>
  </div>
 </form>

 <div class="mt">
  <div>
   <span class="ib" style="background:var(--soft);color:var(--pri)"><span data-i="clipboard-list"></span></span>
   <div><small>Total Laporan</small><b style="color:var(--pri)">{{ $totalLaporan }}</b></div>
  </div>
  <div>
   <span class="ib" style="background:#e5f8f0;color:#10a874"><span data-i="circle-check"></span></span>
   <div><small>Disetujui</small><b style="color:#10a874">{{ $disetujui }}</b></div>
  </div>
  <div>
   <span class="ib" style="background:#fff0f2;color:#f04462"><span data-i="circle-x"></span></span>
   <div><small>Ditolak</small><b style="color:#f04462">{{ $ditolak }}</b></div>
  </div>
 </div>

 <div class="card sh">
  <h2>Daftar Laporan</h2>

  <div class="tw">
   <table>
    <thead><tr><th>No</th><th>Tanggal</th><th>Nama Siswa</th><th>Kelas</th><th>Status</th></tr></thead>
    <tbody>
     @forelse ($reports as $lap)
      @php
       $lbl = $lap->statusLabel();
       $nama = $lap->siswa->nama_siswa ?? 'Siswa';
       $ini = collect(preg_split('/\s+/', trim($nama)))->take(2)->map(fn($w)=>mb_strtoupper(mb_substr($w,0,1)))->join('');
      @endphp
      <tr>
       <td style="color:var(--mut)">{{ $reports->firstItem() + $loop->index }}</td>
       <td>{{ $lap->tanggal->translatedFormat('d M Y') }}</td>
       <td><div class="nm"><span>{{ $nama }}</span><span class="av">{{ $ini }}</span></div></td>
       <td>{{ $lap->siswa->kelas->nama_kelas ?? '-' }}</td>
       <td>
        <span class="pill" style="background:{{ $lbl === 'Disetujui' ? 'var(--ok)' : ($lbl === 'Ditolak' ? 'var(--bad)' : '#94600a') }}">
         {{ $lbl }}
        </span>
       </td>
      </tr>
     @empty
      <tr><td colspan="5" style="text-align:center;color:var(--mut);padding:24px;">Belum ada laporan masuk di database.</td></tr>
     @endforelse
    </tbody>
   </table>
  </div>

  {{ $reports->links() }}
 </div>

 <small style="color:var(--mut);font-size:11px;">Data diperbarui terakhir pada {{ now()->translatedFormat('d F Y, H.i') }} WITA</small>
</section>
@endsection

@push('scripts')
<script>paint();</script>
@endpush
