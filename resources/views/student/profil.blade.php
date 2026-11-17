@extends('layout.student')
@section('title', 'Profil Saya')

@section('content')
<h1 class="page-title">Profil Saya</h1>

<div class="list-stack" style="gap:24px;">
  {{-- Card 1: Ringkasan Profil (Figma 543:7678) --}}
  <section class="card" style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:16px;">
    <div style="display:flex;align-items:center;gap:20px;">
      <img src="{{ asset('images/avatar-akram.jpg') }}" alt="{{ $user->name }}" width="72" height="72" style="width:72px;height:72px;border-radius:999px;object-fit:cover;flex:none;">
      <div style="font-size:20px;font-weight:700;color:var(--navy);">{{ $user->name }}</div>
    </div>
    <div style="display:flex;gap:12px;flex-wrap:wrap;">
      <button type="button" class="btn btn--secondary" onclick="document.getElementById('photoModal').classList.add('is-open')">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
        Ubah foto
      </button>
      <button type="button" class="btn btn--primary" onclick="document.getElementById('editProfileModal').classList.add('is-open')">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
        Ajukan Edit Profil
      </button>
    </div>
  </section>

  {{-- Card 2: Identitas siswa --}}
  <section class="card">
    <h2 class="card__title" style="display:flex;align-items:center;gap:8px;margin-bottom:20px;">
      <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#1f6fd6" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      Identitas siswa
    </h2>
    <div class="info-grid">
      <div class="info-cell">
        <div class="info-cell__label">Nama lengkap</div>
        <div class="info-cell__val">{{ $user->name }}</div>
      </div>
      <div class="info-cell">
        <div class="info-cell__label">NIS / NISN</div>
        <div class="info-cell__val">{{ $siswa->nisn }}</div>
      </div>
      <div class="info-cell" style="border-bottom:0;padding-bottom:0;">
        <div class="info-cell__label">Kelas</div>
        <div class="info-cell__val">{{ $siswa->kelas->nama_kelas ?? '-' }}</div>
      </div>
      <div class="info-cell" style="border-bottom:0;padding-bottom:0;">
        <div class="info-cell__label">Guru Wali</div>
        <div class="info-cell__val">{{ $siswa->guruWali->nama_guru ?? '-' }}</div>
      </div>
    </div>
  </section>

  {{-- Card 3: Informasi akun --}}
  <section class="card">
    <h2 class="card__title" style="display:flex;align-items:center;gap:8px;margin-bottom:20px;">
      <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#1f6fd6" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="9" cy="10" r="2"/><path d="M15 8h2"/><path d="M15 12h2"/><path d="M7 16h10"/></svg>
      Informasi akun
    </h2>
    <div class="info-grid">
      <div class="info-cell">
        <div class="info-cell__label">Email</div>
        <div class="info-cell__val">{{ $user->email ?: '-' }}</div>
      </div>
      <div class="info-cell">
        <div class="info-cell__label">Peran</div>
        <div class="info-cell__val">{{ $user->labelRole() }}</div>
      </div>
      <div class="info-cell" style="border-bottom:0;padding-bottom:0;">
        <div class="info-cell__label">Email Sekolah</div>
        <div class="info-cell__val">{{ $user->email ?: ($user->username . '@smpn21sinjai.sch.id') }}</div>
      </div>
      <div class="info-cell" style="border-bottom:0;padding-bottom:0;">
        <div class="info-cell__label">Nomor telepon</div>
        <div class="info-cell__val">{{ $siswa->guruWali->no_hp ?? '-' }}</div>
      </div>
    </div>
  </section>

  {{-- Card 4: Keamanan akun --}}
  <section class="card">
    <h2 class="card__title" style="display:flex;align-items:center;gap:8px;margin-bottom:16px;">
      <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#1f6fd6" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
      Keamanan akun
    </h2>
    <div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:14px;">
      <p style="font-size:14px;color:var(--muted);margin:0;">Kata sandi hanya bisa diubah lewat pengajuan ke admin sekolah.</p>
      <div style="display:flex;gap:10px;flex-wrap:wrap;">
        <button type="button" class="btn btn--secondary" onclick="document.getElementById('passwordModal').classList.add('is-open')">Ajukan Ubah Kata Sandi</button>
        <button type="button" class="btn btn--danger-soft" onclick="document.getElementById('logoutModal').classList.add('is-open')">
          <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
          Keluar akun
        </button>
      </div>
    </div>
  </section>
</div>

{{-- Modal Edit Profil --}}
<div class="modal-backdrop" id="editProfileModal" role="dialog" aria-modal="true">
  <div class="modal-box">
    <h3 class="modal-box__title">Edit Profil Siswa</h3>
    <form method="POST" action="{{ route('student.profil.update') }}">
      @csrf
      @method('PUT')
      <div class="field">
        <label class="field__label" for="edit_name">Nama Lengkap</label>
        <div class="input-wrap"><input id="edit_name" name="name" value="{{ old('name', $user->name) }}" required></div>
      </div>
      <div class="field">
        <label class="field__label" for="edit_email">Email</label>
        <div class="input-wrap"><input id="edit_email" type="email" name="email" value="{{ old('email', $user->email) }}"></div>
      </div>
      <div class="modal-box__actions">
        <button type="button" class="btn btn--secondary" onclick="document.getElementById('editProfileModal').classList.remove('is-open')">Batal</button>
        <button type="submit" class="btn btn--primary">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

{{-- Modal Ubah Kata Sandi --}}
<div class="modal-backdrop" id="passwordModal" role="dialog" aria-modal="true">
  <div class="modal-box">
    <h3 class="modal-box__title">Ubah Kata Sandi</h3>
    <form method="POST" action="{{ route('student.profil.password') }}">
      @csrf
      @method('PUT')
      <div class="field">
        <label class="field__label" for="current_password">Kata Sandi Saat Ini</label>
        <div class="input-wrap"><input id="current_password" type="password" name="current_password" autocomplete="current-password" required></div>
      </div>
      <div class="field">
        <label class="field__label" for="new_password">Kata Sandi Baru (min. 8 huruf &amp; angka)</label>
        <div class="input-wrap"><input id="new_password" type="password" name="password" autocomplete="new-password" required></div>
      </div>
      <div class="field">
        <label class="field__label" for="new_password_confirmation">Konfirmasi Kata Sandi Baru</label>
        <div class="input-wrap"><input id="new_password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" required></div>
      </div>
      <div class="modal-box__actions">
        <button type="button" class="btn btn--secondary" onclick="document.getElementById('passwordModal').classList.remove('is-open')">Batal</button>
        <button type="submit" class="btn btn--primary">Perbarui Kata Sandi</button>
      </div>
    </form>
  </div>
</div>

{{-- Modal Ubah Foto --}}
<div class="modal-backdrop" id="photoModal" role="dialog" aria-modal="true">
  <div class="modal-box">
    <h3 class="modal-box__title">Ubah Foto Profil</h3>
    <p class="modal-box__text">Foto profil siswa saat ini menggunakan inisial akun ({{ $user->inisial() }}). Pengajuan perubahan foto formal dapat dilakukan melalui admin sekolah.</p>
    <div class="modal-box__actions">
      <button type="button" class="btn btn--primary" onclick="document.getElementById('photoModal').classList.remove('is-open')">Mengerti</button>
    </div>
  </div>
</div>

{{-- Modal Konfirmasi Keluar --}}
<div class="modal-backdrop" id="logoutModal" role="dialog" aria-modal="true">
  <div class="modal-box">
    <h3 class="modal-box__title">Konfirmasi Keluar</h3>
    <p class="modal-box__text">Apakah Anda yakin ingin keluar dari akun G7KAIH?</p>
    <div class="modal-box__actions">
      <button type="button" class="btn btn--secondary" onclick="document.getElementById('logoutModal').classList.remove('is-open')">Batal</button>
      <form method="POST" action="{{ route('logout') }}" style="margin:0;">
        @csrf
        <button type="submit" class="btn btn--danger">Ya, Keluar</button>
      </form>
    </div>
  </div>
</div>
@endsection
