@extends('layout.admin')
@section('title', 'Pengaturan Admin')
@section('footer_note', 'Zona waktu sekolah: WITA (UTC+8)')

@section('content')
    <section class="view on" id="set" style="gap:12px">
     <div><h1 style="font-size:24px;line-height:32px">Pengaturan Admin</h1><p class="sub" style="font-size:13px;line-height:20px;margin-top:4px">Kelola identitas sekolah, pelaporan, dan keamanan akun dalam satu tempat.</p></div>
     <div class="set" style="flex-direction:row;align-items:center;flex-wrap:wrap;gap:12px"><div class="hd" style="width:250px"><div class="ib"><span data-i="calendar-days"></span></div><div><h2 style="margin:0 0 5px">Tahun ajaran aktif</h2><small>Periode acuan untuk seluruh laporan siswa.</small></div></div>
      <div class="fld m" style="flex:0 0 205px"><label>Tahun ajaran</label><label class="ctl h32"><select aria-label="Tahun ajaran"><option>2025 / 2026</option><option>2024 / 2025</option></select><span data-i="chevron-down"></span></label></div>
      <div class="fld m" style="flex:0 0 205px"><label>Semester</label><label class="ctl h32"><select aria-label="Semester"><option>Ganjil</option><option>Genap</option></select><span data-i="chevron-down"></span></label></div>
      <div class="pd"><b>● Periode aktif</b><span>Laporan baru akan masuk ke tahun ajaran ini.</span></div></div>
     <div class="row" style="align-items:flex-start">
      <div style="flex:1;display:flex;flex-direction:column;gap:16px;min-width:0">
       <div class="set"><div class="hd"><div class="ib"><span data-i="school"></span></div><div><h2>Identitas sekolah</h2><small>Informasi yang ditampilkan pada laporan sekolah.</small></div></div>
        <div class="fld m"><label>Nama sekolah</label><label class="ctl"><input value="SMPN 21 Sinjai"></label></div>
        <div class="r2"><div class="fld m"><label>Email sekolah</label><label class="ctl"><input value="smpn21sinjai@gmail.com"></label></div><div class="fld m"><label>Nomor telepon</label><label class="ctl"><input placeholder="Masukkan nomor telepon"></label></div></div>
        <div class="fld m"><label>Alamat sekolah</label><label class="ctl"><input value="Kabupaten Sinjai, Sulawesi Selatan"></label></div></div>
       <div class="set"><div class="hd"><div class="ib"><span data-i="bell"></span></div><div><h2>Preferensi notifikasi</h2><small>Pilih pemberitahuan yang diterima admin.</small></div></div>
        <div class="nl"><div class="opt"><div><b>Pengingat pelaporan harian</b><small>Ingatkan siswa yang belum mengisi laporan.</small></div><label class="sw"><input type="checkbox" checked><s></s></label></div><div class="opt"><div><b>Laporan menunggu verifikasi</b><small>Beri tahu saat ada laporan yang perlu ditinjau.</small></div><label class="sw"><input type="checkbox" checked><s></s></label></div><div class="opt"><div><b>Ringkasan mingguan via email</b><small>Kirim rekap pelaporan setiap Senin pagi.</small></div><label class="sw"><input type="checkbox"><s></s></label></div></div>
        <div class="fld m"><label>Waktu pengingat harian</label><label class="ctl"><input value="19.00 WITA"><span data-i="clock"></span></label></div>
        <div style="display:flex;gap:4px;color:var(--mut);font-size:11px;line-height:16px"><span data-i="info" style="font-size:14px"></span>Notifikasi admin muncul di aplikasi. Ringkasan email dikirim ke alamat email akun admin.</div></div>
      </div>
      <div style="flex:1;display:flex;flex-direction:column;gap:16px;min-width:0">
       <div class="set"><div class="hd"><div class="ib"><span data-i="file-text"></span></div><div><h2>Ketentuan pelaporan harian</h2><small>Atur jadwal pengisian dan ketentuan laporan 7 Kebiasaan Anak Indonesia Hebat.</small></div></div>
        <div class="r2"><div class="fld m"><label>Hari pelaporan</label><label class="ctl"><select><option>Setiap hari (Senin–Minggu)</option><option>Senin–Jumat</option></select><span data-i="chevron-down"></span></label></div><div class="fld m"><label>Batas waktu pengisian</label><label class="ctl"><input value="21.00 WITA"><span data-i="clock"></span></label></div><div class="fld m"><label>Batas revisi laporan</label><label class="ctl"><select><option>1 hari setelah dikirim</option><option>3 hari setelah dikirim</option></select><span data-i="chevron-down"></span></label></div></div>
        <div class="r2"><div class="opt" style="flex:1"><div><b>Wajib verifikasi guru wali</b><small>Setiap laporan diperiksa oleh guru wali siswa.</small></div><label class="sw"><input type="checkbox" checked><s></s></label></div><div class="opt" style="flex:1"><div><b>Izinkan laporan terlambat</b><small>Siswa tetap dapat mengisi setelah batas waktu.</small></div><label class="sw"><input type="checkbox"><s></s></label></div></div>
        <div class="note b"><span data-i="info"></span>Ketentuan baru berlaku untuk laporan berikutnya. Laporan yang sudah masuk tidak berubah.</div></div>
       <div class="set"><div class="hd"><div class="ib"><span data-i="shield-check"></span></div><div><h2>Keamanan akun admin</h2><small>Lindungi akses akun Admin Sekolah.</small></div></div>
        <div class="fld m"><label>Email akun admin</label><label class="ctl"><input value="admin@smpn21sinjai.sch.id"></label></div>
        <div class="fld m"><label>Kata sandi saat ini</label><label class="ctl"><input type="password" placeholder="Masukkan kata sandi saat ini"><span data-i="eye-off"></span></label></div>
        <div class="r2"><div class="fld m"><label>Kata sandi baru</label><label class="ctl"><input type="password" placeholder="Minimal 8 karakter"><span data-i="eye-off"></span></label></div><div class="fld m"><label>Konfirmasi kata sandi</label><label class="ctl"><input type="password" placeholder="Ulangi kata sandi baru"><span data-i="eye-off"></span></label></div></div>
        <p style="color:var(--mut);font-size:10px;line-height:16px">Gunakan kombinasi huruf dan angka. Kosongkan kolom kata sandi jika tidak ingin menggantinya.</p>
        <div class="opt"><div><b>Keluar otomatis saat tidak aktif</b><small>Akhiri sesi setelah 30 menit tanpa aktivitas.</small></div><label class="sw"><input type="checkbox" checked><s></s></label></div></div>
      </div></div>
     <div class="bar"><div><b>Simpan pengaturan sekolah Anda</b><small>Perubahan diterapkan setelah Anda menyimpannya.</small></div><button class="btn o sm" onclick="toast('Perubahan dibatalkan')">Batal</button><button class="btn sm" style="font-size:12px" onclick="toast('Pengaturan disimpan')"><span data-i="save" style="font-size:15px"></span>Simpan Perubahan</button></div>
    </section>
@endsection

@push('scripts')
<script>

paint();
</script>
@endpush
