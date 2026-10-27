@extends('layout.admin')
@section('title', 'Atur Perwalian')

@section('content')
    <section class="view on" id="wali">
     <div><h1>Atur Perwalian</h1><p class="sub">Tetapkan guru wali dan kelola siswa pada setiap kelas.</p></div>
     <div class="card" style="border-radius:12px"><h2>Pengaturan Kelas &amp; Guru Wali</h2>
      <div class="row"><div class="fld"><label for="fk">Kelas</label><label class="ctl"><select id="fk"><option value="">Semua Kelas</option></select><span data-i="chevron-down"></span></label></div><div class="fld"><label for="fg">Guru Wali</label><label class="ctl"><select id="fg"><option value="">Semua Guru Wali</option></select><span data-i="chevron-down"></span></label></div></div>
      <div class="tw"><table><thead><tr><th>Kelas</th><th>Guru Wali</th><th>Jumlah Siswa</th><th style="width:72px">Aksi</th></tr></thead><tbody id="waliB"></tbody></table></div>
      <div style="display:flex;justify-content:flex-end"><button class="btn" onclick="toast('Perubahan perwalian disimpan')"><span data-i="save"></span>Simpan Perubahan</button></div></div>
     <div class="info"><span data-i="info"></span><div><span>Satu kelas, satu guru wali</span><p>Guru wali dapat memantau dan memverifikasi laporan siswa yang ada di kelas perwaliannya.</p></div></div>
    </section>
@endsection

@push('scripts')
<script>
const KELAS=[['VII-A','Andi Saputra',32],['VII-B','Siti Nurhaliza',32],['VIII-A','Riski Ramadhan',30],['VIII-B','Nur Aisyah',31]];
$('#fk').innerHTML+=KELAS.map(k=>`<option>${k[0]}</option>`).join('');
$('#fg').innerHTML+=KELAS.map(k=>`<option>${k[1]}</option>`).join('');
function wali(){const k=$('#fk').value,g=$('#fg').value;
 $('#waliB').innerHTML=KELAS.filter(r=>(!k||r[0]===k)&&(!g||r[1]===g)).map(r=>`<tr><td>${r[0]}</td><td>${r[1]}</td><td>${r[2]}</td><td><button class="btn s" onclick="toast('Kelola kelas ${r[0]}')">Kelola</button></td></tr>`).join('')}
$('#fk').onchange=$('#fg').onchange=wali;wali();
paint();
</script>
@endpush
