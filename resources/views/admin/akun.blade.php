@extends('layout.admin')
@section('title', 'Kelola Akun & Pengguna')

@section('content')
    <section class="view on" id="akun">
     <div class="top"><div><h1>Kelola Akun &amp; Pengguna</h1><p class="sub">Kelola akses guru wali dan siswa SMPN 21 Sinjai.</p></div><button class="btn" onclick="toast('Form tambah akun dibuka')"><span data-i="plus"></span>Tambah Akun</button></div>
     <div class="card">
      <div class="tabs" id="tabs"><button class="tab on" data-t="g">Guru &amp; Staf</button><button class="tab" data-t="s">Siswa</button></div>
      <div class="row" style="gap:12px"><label class="ctl" style="flex:1"><input id="q" placeholder="Cari nama atau username..." aria-label="Cari"><span data-i="search"></span></label><label class="ctl" style="flex:1"><select id="stf" aria-label="Status"><option value="">Semua Status</option><option>Aktif</option><option>Nonaktif</option></select><span data-i="chevron-down"></span></label></div>
      <div class="tw"><table><thead><tr><th style="width:28px">No</th><th>Nama</th><th>Username</th><th>Role</th><th>Status</th><th style="width:72px">Aksi</th></tr></thead><tbody id="akunB"></tbody></table></div>
      <div class="pg" id="pg1"></div>
     </div>
     <div class="card bd"><h2>Reset Password</h2><p style="color:var(--mut)">Pilih akun yang memerlukan pengaturan ulang password.</p>
      <div class="row" style="align-items:flex-end;gap:12px"><div class="fld"><label for="ru">Username</label><label class="ctl"><input id="ru" placeholder="Masukkan username"></label></div><button class="btn" onclick="toast('Password berhasil direset')"><span data-i="key-round"></span>Reset Password</button></div></div>
    </section>
@endsection

@push('scripts')
<script>
const USERS={g:[['Andi Saputra','andi.putra','Guru Wali','Aktif'],['Siti Nurhaliza','siti.nur','Guru Wali','Nonaktif'],['Riski Ramadhan','riski.rama','Guru Wali','Aktif'],['Nur Aisyah','nur.aisyah','Guru Wali','Aktif']],s:[['Fajar Maulana','fajar.m','Siswa','Aktif'],['Dewi Anggraini','dewi.a','Siswa','Aktif'],['Rizky Pratama','rizky.p','Siswa','Nonaktif'],['Lestari Putri','lestari.p','Siswa','Aktif']]};
let tab='g';
function akun(){const q=$('#q').value.toLowerCase(),s=$('#stf').value;
 const r=USERS[tab].filter(u=>(!s||u[3]===s)&&(u[0]+u[1]).toLowerCase().includes(q));
 $('#akunB').innerHTML=r.length?r.map((u,i)=>`<tr><td>${i+1}</td><td>${nameCell(u[0])}</td><td>${u[1]}</td><td>${u[2]}</td><td>${pill(u[3])}</td><td><div class="ic"><button class="e" aria-label="Ubah ${u[0]}" onclick="toast('Ubah akun ${u[0]}')">${ic('pencil')}</button><button class="d" aria-label="Hapus ${u[0]}" onclick="toast('Hapus akun ${u[0]}')">${ic('trash')}</button></div></td></tr>`).join(''):'<tr><td colspan="6" style="text-align:center;color:var(--mut);padding:28px">Tidak ada akun yang cocok.</td></tr>'}
$('#tabs').onclick=e=>{const b=e.target.closest('.tab');if(!b)return;tab=b.dataset.t;$$('.tab').forEach(x=>x.classList.toggle('on',x===b));akun()};
$('#q').oninput=akun;$('#stf').onchange=akun;akun();pager('#pg1');
paint();
</script>
@endpush
