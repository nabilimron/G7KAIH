@extends('layout.admin')
@section('title', 'Pemantauan Seluruh Laporan')

@section('content')
     <section class="view on" id="lapor">
     <div><h1>Pemantauan Seluruh Laporan</h1><p class="sub">Pantau aktivitas pelaporan seluruh kelas di sekolah.</p></div>
     <div class="row" style="gap:12px"><div class="fld"><label for="lp">Periode</label><label class="ctl"><select id="lp"><option>Harian</option><option>Mingguan</option><option>Bulanan</option></select><span data-i="chevron-down"></span></label></div><div class="fld"><label for="lt">Tanggal</label><label class="ctl"><input id="lt" type="date" value="2025-09-22"></label></div><div class="fld"><label for="lk">Kelas</label><label class="ctl"><select id="lk"><option value="">Semua Kelas</option></select><span data-i="chevron-down"></span></label></div></div>
     <div class="mt"><div><div class="ib"><span data-i="clipboard-list"></span></div><div><small>Total Laporan</small><b style="color:var(--pri)">902</b></div></div><div><div class="ib" style="background:#e5f8f0;color:#10a874"><span data-i="circle-check"></span></div><div><small>Disetujui</small><b style="color:#10a874">498</b></div></div><div><div class="ib" style="background:#fff0f2;color:#f04462"><span data-i="circle-x"></span></div><div><small>Ditolak</small><b style="color:#f04462">361</b></div></div></div>
     <div class="card sh"><h2>Daftar Laporan</h2><div class="tw"><table><thead><tr><th style="width:28px;background:#f8fafc">No</th><th style="background:#f8fafc">Tanggal</th><th style="background:#f8fafc">Nama Siswa</th><th style="background:#f8fafc">Kelas</th><th style="background:#f8fafc">Status</th></tr></thead><tbody id="lapB"></tbody></table></div><div class="pg" id="pg2"></div></div>
     <p style="color:var(--mut);font-size:11px">Data diperbarui terakhir pada 22 September 2025, 14.30 WITA</p>
    </section>
@endsection

@push('scripts')
<script>
const KELAS=[['VII-A','Andi Saputra',32],['VII-B','Siti Nurhaliza',32],['VIII-A','Riski Ramadhan',30],['VIII-B','Nur Aisyah',31]];
$('#lk').innerHTML+=KELAS.map(k=>`<option>${k[0]}</option>`).join('');
const LAP=[['20 Sep 2025','Andi Saputra','VII-A','Disetujui'],['22 Sep 2025','Nur Aisyah','VII-B','Disetujui'],['22 Sep 2025','Riski Ramadhan','VIII-A','Menunggu'],['22 Sep 2025','Siti Nurhaliza','VII-B','Ditolak'],['22 Sep 2025','Fajar Maulana','VIII-A','Disetujui']];
function lap(){const k=$('#lk').value;$('#lapB').innerHTML=LAP.filter(r=>!k||r[2]===k).map((r,i)=>`<tr><td>${i+1}</td><td>${r[0]}</td><td>${nameCell(r[1])}</td><td>${r[2]}</td><td>${pill(r[3])}</td></tr>`).join('')}
$('#lk').onchange=lap;lap();
pager('#pg2');
paint();
</script>
@endpush