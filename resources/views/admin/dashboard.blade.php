@extends('layout.admin')
@section('title', 'Dashboard Admin')
@section('footer_note', 'Terakhir diperbarui pukul 10.30 WITA')

@section('content')
    <section class="view on" id="dash">
     <div class="top"><div><h1>Dashboard Admin</h1><p class="sub">Pantau pelaksanaan 7 Kebiasaan Anak Indonesia Hebat di sekolah.</p></div><div class="date"><span data-i="calendar-days"></span>Senin, 18 Agustus 2025</div></div>
     <div class="g4" id="stats"></div>
     <div class="g2">
      <div class="card" style="gap:18px"><div class="row" style="align-items:center"><div style="flex:1"><h2>Tren pelaporan</h2><p class="ps">Jumlah laporan masuk setiap hari</p></div><div class="ctl" style="width:130px"><select style="height:32px;font-size:11px" aria-label="Rentang"><option>7 hari terakhir</option><option>30 hari terakhir</option></select><span data-i="chevron-down"></span></div></div>
       <div style="display:flex;gap:8px;align-items:baseline"><b style="font-size:23px">1.248</b><span style="color:var(--mut);font-size:11px">laporan</span><b class="up" style="font-size:11px;font-weight:500">↑ 12,4%</b></div>
       <div class="plot"><div class="ylab"><span>300</span><span>200</span><span>100</span><span>0</span></div><div class="bars"><div class="pl" id="pl"></div><div class="days"><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span><span>Min</span><span>Sen</span></div></div></div>
       <small style="color:var(--mut);font-size:10px">12–18 Agustus 2025 · Seluruh kelas</small></div>
      <div class="card"><div><h2>Status verifikasi</h2><p class="ps">Laporan minggu ini</p></div>
       <div style="display:flex;gap:8px;align-items:baseline"><b style="font-size:28px">82,1%</b><span style="color:var(--mut);font-size:11px">telah diverifikasi</span></div>
       <div class="seg"><i style="background:var(--ok);flex:82.1"></i><i style="background:#b77913;flex:14.9"></i><i style="background:var(--bad);flex:3"></i></div>
       <div style="display:flex;flex-direction:column;gap:14px">
        <div class="st"><i style="background:var(--ok)"></i><span>Terverifikasi</span><b>1.024</b><em>82,1%</em></div>
        <div class="st"><i style="background:#b77913"></i><span>Menunggu verifikasi</span><b>186</b><em>14,9%</em></div>
        <div class="st"><i style="background:var(--bad)"></i><span>Perlu perbaikan</span><b>38</b><em>3,0%</em></div></div>
       <a class="lnk" href="{{ url('admin/laporan') }}">Lihat pemantauan keseluruhan <span data-i="arrow-right" style="font-size:15px"></span></a></div>
     </div>
     <div class="g2">
      <div class="card"><div class="row" style="align-items:center"><h2 style="flex:1">Aktivitas terbaru</h2><button style="color:var(--pri);font-weight:600;font-size:11px" onclick="toast('Membuka semua aktivitas')">Lihat semua</button></div><div id="acts"></div></div>
      <div class="card"><h2>Akses cepat</h2><div id="quick"></div></div>
     </div>
    </section>
@endsection

@push('scripts')
<script>
const STATS=[['Total siswa','users-round','384','Tersebar di 12 kelas'],['Guru wali','user-round-check','24','Seluruh akun aktif'],['Perwalian terisi','school','372 / 384','12 siswa belum memiliki wali'],['Laporan minggu ini','file-text','1.248','↑ 12,4% dari minggu lalu','up']];
const ACT=[['file-check','#e9f6f1','Andi Saputra memverifikasi 24 laporan','Kelas VII A · Laporan kebiasaan harian','10.25 WITA'],['user-round-plus','#eaf4ff','8 akun siswa baru berhasil ditambahkan','Admin Sekolah · Kelas VII B','09.50 WITA'],['school','#eaf4ff','Perwalian kelas VIII A diperbarui','Siti Nurhaliza · 16 siswa perwalian','09.15 WITA'],['award','#fff6e5','12 siswa meraih badge Konsisten 7 Hari','Pencapaian kebiasaan · Seluruh kelas','08.40 WITA']];
const QUICK=[['users-round','akun','Kelola Akun & Pengguna','Tambah dan atur akses pengguna'],['school','wali','Atur Perwalian','Lengkapi 12 siswa tanpa guru wali'],['award','badge','Badge Pencapaian','Kelola penghargaan kebiasaan siswa'],['chart-column','lapor','Pemantauan Keseluruhan','Tinjau seluruh laporan dan verifikasi']];
const BAR=[126,164,138,192,162,224,242];
$('#stats').innerHTML=STATS.map(s=>`<div class="stat"><div><span>${s[0]}</span><span class="ib">${ic(s[1])}</span></div><b>${s[2]}</b><small class="${s[4]||''}">${s[3]}</small></div>`).join('');
$('#pl').innerHTML=BAR.map(v=>`<i style="height:${v/300*150}px" title="${v} laporan"></i>`).join('');
$('#acts').innerHTML=ACT.map(a=>`<div class="act"><div class="c" style="background:${a[1]};color:${a[0]==='file-check'?'var(--ok)':a[0]==='award'?'#b77913':'var(--pri)'}">${ic(a[0])}</div><div>${a[2]}<small>${a[3]}</small></div><span>${a[4]}</span></div>`).join('');
$('#quick').innerHTML=QUICK.map(q=>`<a class="act" href="${LINK[q[1]]}"><div class="c q" style="background:var(--soft);color:var(--pri)">${ic(q[0])}</div><div style="font-weight:600;font-size:11px">${q[2]}<small>${q[3]}</small></div>${ic('chevron-right')}</a>`).join('');
paint();
</script>
@endpush
