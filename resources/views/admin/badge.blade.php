@extends('layout.admin')
@section('title', 'Atur Badge Pencapaian')

@section('content')
    <section class="view on" id="badge">
     <div><h1>Atur Badge Pencapaian</h1><p class="sub">Kelola syarat pencapaian dan badge untuk kebiasaan baik siswa.</p></div>
     <div class="card sh"><h2>Pengaturan Pencapaian</h2>
      <div class="opt" style="align-items:center"><div style="gap:5px"><span style="font-size:13px">Berikan badge secara otomatis</span><small style="font-size:12px;line-height:1.5">Badge diberikan ketika syarat terpenuhi dari laporan yang disetujui guru wali.</small></div><label class="sw l"><input type="checkbox" checked aria-label="Badge otomatis"><s></s></label></div>
      <div class="note" style="align-items:center"><span data-i="shield-check"></span>Hanya laporan disetujui yang dihitung. Laporan menunggu atau ditolak tidak menambah kemajuan badge.</div>
      <div style="display:flex;justify-content:flex-end"><button class="btn" onclick="toast('Pengaturan disimpan')"><span data-i="save"></span>Simpan Pengaturan</button></div></div>
     <div class="card sh"><div class="row" style="align-items:center"><div style="flex:1"><h2 style="font-size:16px">Daftar Badge</h2><p class="ps" style="margin-top:4px">6 badge aktif untuk siswa</p></div><button class="btn" onclick="toast('Form tambah badge dibuka')"><span data-i="plus"></span>Tambah Badge</button></div>
      <div class="tw"><table style="min-width:720px"><thead><tr><th style="font-weight:400">Nama Badge</th><th style="width:170px;font-weight:400">Kebiasaan / Syarat</th><th style="width:168px;font-weight:400">Target Pencapaian</th><th style="width:78px;font-weight:400">Status</th><th style="width:54px;font-weight:400">Aksi</th></tr></thead><tbody id="badgeB"></tbody></table></div>
      <div class="lg"><div><b style="font-size:14px">Pengaturan Logo Badge</b><p class="ps">Pilih logo solid untuk setiap badge agar tampilan lebih konsisten dan mudah dikenali.</p></div>
       <div class="row"><div style="width:220px"><b style="font-size:11px;display:block;margin-bottom:8px;font-weight:600">Logo Badge</b><div id="logos" style="display:flex;flex-wrap:wrap;gap:8px"></div></div><div><b style="font-size:11px;display:block;margin-bottom:8px;font-weight:600">Aksi Logo</b><button class="btn s" style="background:var(--soft);color:var(--pri);border:1px solid #cfe4fb;padding:10px 12px" onclick="toast('Pilih logo baru')">Ubah logo</button></div></div></div></div>
    </section>
@endsection

@push('scripts')
<script>
const BADGE=[['sunrise','#247ef2','Si Pagi Hebat','Bangun pagi','7 hari berturut-turut'],['heart-handshake','#e34557','Rajin Beribadah','Ibadah lengkap','7 hari'],['book-open','#238ce2','Sahabat Buku','Gemar belajar','7 hari'],['clipboard-check','#17b979','Pelapor Konsisten','Laporan disetujui','10 laporan'],['bike','#34b6ca','Aktif Bergerak','Olahraga','10 hari'],['award','#efbd37','Generasi Hebat','7 kebiasaan lengkap','30 hari']];
$('#badgeB').innerHTML=BADGE.map(b=>`<tr><td><div style="display:flex;gap:12px;align-items:center;font-size:12px"><span class="bi" style="background:${b[1]}">${ic(b[0])}</span>${b[2]}</div></td><td>${b[3]}</td><td>${b[4]}</td><td>${pill('Aktif')}</td><td><div class="ic" style="gap:10px"><button class="e" aria-label="Ubah ${b[2]}" onclick="toast('Ubah badge ${b[2]}')">${ic('pencil')}</button><button class="d" aria-label="Hapus ${b[2]}" onclick="toast('Hapus badge ${b[2]}')">${ic('trash')}</button></div></td></tr>`).join('');
$('#logos').innerHTML=BADGE.map(b=>`<button class="bi" style="background:${b[1]}" aria-label="Logo ${b[2]}" onclick="toast('Logo ${b[2]} dipilih')">${ic(b[0])}</button>`).join('');
paint();
</script>
@endpush
