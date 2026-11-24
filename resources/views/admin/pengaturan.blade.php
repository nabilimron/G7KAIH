@extends('layout.admin')
@section('title', 'Pengaturan Admin')
@section('footer_note', 'Zona waktu sekolah: WITA (UTC+8)')

@section('content')
<section class="view on">
 <div class="top">
  <div><h1>Pengaturan Admin</h1><p class="sub">Kelola identitas sekolah, pelaporan, dan keamanan akun dalam satu tempat.</p></div>
 </div>

 <form method="POST" action="{{ route('admin.pengaturan.update') }}" style="display:flex;flex-direction:column;gap:16px;">
  @csrf @method('PUT')

  <div class="bar" style="flex-wrap:wrap;padding:16px;">
   <div style="display:flex;gap:10px;align-items:center;min-width:220px;flex:1;">
    <span class="ib"><span data-i="calendar-days"></span></span>
    <div>
     <b>Tahun ajaran aktif</b>
     <small>Periode acuan untuk seluruh laporan siswa.</small>
    </div>
   </div>
   <div class="fld" style="min-width:170px;flex:0.8;">
    <label for="s_tahun">Tahun ajaran</label>
    <div class="ctl h28"><input id="s_tahun" name="tahun_ajaran" value="{{ old('tahun_ajaran', $semester->tahun_ajaran ?? '2026/2027') }}" required></div>
   </div>
   <div class="fld" style="min-width:150px;flex:0.7;">
    <label for="s_sem">Semester</label>
    <div class="ctl h28">
     <select id="s_sem" name="nama_semester">
      <option value="Ganjil" @selected(old('nama_semester', $semester->nama_semester ?? '') === 'Ganjil')>Ganjil</option>
      <option value="Genap" @selected(old('nama_semester', $semester->nama_semester ?? '') === 'Genap')>Genap</option>
     </select>
     <span data-i="chevron-down"></span>
    </div>
   </div>
   <div class="pd">
    <b>&bull; Periode aktif</b>
    <span>Laporan baru akan masuk ke tahun ajaran ini.</span>
   </div>
  </div>

  @if ($errors->any())
   <div class="note" style="background:var(--badbg);color:var(--bad);">
    <span>{{ $errors->first() }}</span>
   </div>
  @endif

  <div class="g2 eq">
   <div class="set">
    <div class="hd">
     <span class="ib"><span data-i="school"></span></span>
     <div><h2>Identitas sekolah</h2><small>Informasi yang ditampilkan pada laporan sekolah.</small></div>
    </div>
    <div class="fld m"><label for="sch_name">Nama sekolah</label><div class="ctl"><input id="sch_name" value="SMPN 21 Sinjai" readonly></div></div>
    <div class="r2">
     <div class="fld m"><label for="sch_mail">Email sekolah</label><div class="ctl"><input id="sch_mail" value="admin@smpn21sinjai.sch.id" readonly></div></div>
     <div class="fld m"><label for="sch_tel">Nomor telepon</label><div class="ctl"><input id="sch_tel" value="0852-5575-2831" readonly></div></div>
    </div>
    <div class="fld m"><label for="sch_addr">Alamat sekolah</label><div class="ctl"><input id="sch_addr" value="Kabupaten Sinjai, Sulawesi Selatan" readonly></div></div>
   </div>

   <div class="set">
    <div class="hd">
     <span class="ib"><span data-i="file-text"></span></span>
     <div><h2>Ketentuan pelaporan harian</h2><small>Atur jadwal pengisian dan ketentuan laporan 7 Kebiasaan.</small></div>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(130px,1fr));gap:8px;">
     <div class="fld m"><label for="kp_hari">Hari pelaporan</label><div class="ctl"><input id="kp_hari" value="Setiap hari (Senin - Minggu)" readonly></div></div>
     <div class="fld m"><label for="kp_batas">Batas waktu pengisian</label><div class="ctl"><input id="kp_batas" value="21.00 WITA" readonly><span data-i="clock"></span></div></div>
     <div class="fld m">
      <label for="kp_revisi">Batas revisi laporan</label>
      <div class="ctl">
       <select id="kp_revisi"><option selected>1 hari setelah dikirim</option><option>3 hari setelah dikirim</option></select>
       <span data-i="chevron-down"></span>
      </div>
     </div>
    </div>
    <div class="r2">
     <div class="opt" style="flex:1;"><div style="flex:1"><b>Wajib verifikasi guru wali</b><small>Setiap laporan diperiksa oleh guru wali siswa.</small></div><label class="sw"><input type="checkbox" checked><s></s></label></div>
     <div class="opt" style="flex:1;"><div style="flex:1"><b>Izinkan laporan terlambat</b><small>Siswa tetap dapat mengisi setelah batas waktu.</small></div><label class="sw"><input type="checkbox" checked><s></s></label></div>
    </div>
    <div class="note"><span data-i="info"></span><span>Ketentuan berlaku untuk laporan berikutnya. Laporan yang sudah masuk tetap aman.</span></div>
   </div>

   <div class="set">
    <div class="hd">
     <span class="ib"><span data-i="bell"></span></span>
     <div><h2>Preferensi notifikasi</h2><small>Pilih pemberitahuan yang diterima admin.</small></div>
    </div>
    <div class="nl">
     <div class="opt"><div><b>Pengingat pelaporan harian</b><small>Ingatkan siswa yang belum mengisi laporan.</small></div><label class="sw"><input type="checkbox" checked><s></s></label></div>
     <div class="opt"><div><b>Laporan menunggu verifikasi</b><small>Beri tahu saat ada laporan yang perlu ditinjau.</small></div><label class="sw"><input type="checkbox" checked><s></s></label></div>
     <div class="opt"><div><b>Ringkasan mingguan via email</b><small>Kirim rekap pelaporan setiap Senin pagi.</small></div><label class="sw"><input type="checkbox"><s></s></label></div>
    </div>
    <div class="fld m"><label for="notif_time">Waktu pengingat harian</label><div class="ctl"><input id="notif_time" value="19.00 WITA" readonly><span data-i="clock"></span></div></div>
    <div style="display:flex;gap:8px;align-items:flex-start;font-size:12px;color:var(--mut);">
     <span data-i="info" style="font-size:14px;"></span>
     <span>Notifikasi admin muncul di aplikasi. Ringkasan email dikirim ke alamat email akun admin.</span>
    </div>
   </div>

   <div class="set">
    <div class="hd">
     <span class="ib"><span data-i="shield-check"></span></span>
     <div><h2>Keamanan akun admin</h2><small>Lindungi akses akun Admin Sekolah ({{ $admin->username ?? 'admin1' }}).</small></div>
    </div>
    <div class="fld m"><label for="adm_mail">Email akun admin</label><div class="ctl"><input id="adm_mail" value="{{ $admin->email ?? 'admin1@smpn21sinjai.sch.id' }}" readonly></div></div>
    <div class="fld m"><label for="adm_cur">Kata sandi saat ini</label><div class="ctl"><input id="adm_cur" type="password" name="current_password" placeholder="Masukkan kata sandi saat ini"><span data-i="eye-off"></span></div></div>
    <div class="r2">
     <div class="fld m"><label for="adm_new">Kata sandi baru</label><div class="ctl"><input id="adm_new" type="password" name="password" placeholder="Minimal 8 karakter"><span data-i="eye-off"></span></div></div>
     <div class="fld m"><label for="adm_cnf">Konfirmasi kata sandi</label><div class="ctl"><input id="adm_cnf" type="password" name="password_confirmation" placeholder="Ulangi kata sandi baru"><span data-i="eye-off"></span></div></div>
    </div>
    <small style="color:var(--mut);font-size:12px;">Gunakan kombinasi huruf dan angka. Kosongkan kolom kata sandi jika tidak ingin menggantinya.</small>
    <div class="opt" style="padding-top:6px;border-top:1px solid var(--line);"><div><b>Keluar otomatis saat tidak aktif</b><small>Akhiri sesi setelah 30 menit tanpa aktivitas.</small></div><label class="sw"><input type="checkbox" checked><s></s></label></div>
   </div>
  </div>

  <div class="bar" style="flex-wrap:wrap;">
   <div><b>Simpan pengaturan sekolah Anda</b><small>Perubahan diterapkan setelah Anda menyimpannya ke database db_g7kaih.</small></div>
   <a class="btn o sm" href="{{ route('admin.pengaturan') }}">Batal</a>
   <button class="btn sm" type="submit"><span data-i="save"></span>Simpan Perubahan</button>
  </div>
 </form>
</section>
@endsection

@push('scripts')
<script>
 paint();
 @if (session('ok')) toast(@json(session('ok'))); @endif
</script>
@endpush
