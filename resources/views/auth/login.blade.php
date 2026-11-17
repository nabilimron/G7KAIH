<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Masuk — G7KAIH SMPN 21 Sinjai</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/g7kaih-app.css') }}">
  <script>if (localStorage.getItem('g7kaih-theme') === 'dark') document.documentElement.setAttribute('data-theme', 'dark');</script>
</head>
<body>
<div class="login-canvas">
  <header class="login-header">
    <a class="login-brand-pill" href="{{ route('home') }}">
      <img class="brand__logo" src="{{ asset('images/logo-g7kaih.png') }}" alt="Logo G7KAIH" width="40" height="40">
      <span class="brand__text">
        <span class="brand__name">G7KAIH</span>
        <span class="brand__sub">SMPN 21 Sinjai</span>
      </span>
    </a>

    <div class="login-header-right">
      <span class="login-motto">Kolaborasi untuk Generasi Hebat</span>
    </div>
  </header>

  <main class="login-card" aria-labelledby="login-title">
    <h1 class="login-card__title" id="login-title">Selamat Datang</h1>
    <p class="login-card__sub">Silakan masuk untuk melanjutkan</p>

    @if (session('ok'))
      <div class="alert alert--ok" role="status">{{ session('ok') }}</div>
    @endif

    @if (session('login_error'))
      <div class="alert alert--error" role="alert">
        <div>
          <strong>Gagal Masuk</strong><br>
          {{ session('login_error') }}
        </div>
      </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
      @csrf
      <div class="field">
        <label class="field__label" for="username">Email Sekolah</label>
        <div class="input-wrap">
          <span class="input-wrap__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
          </span>
          <input id="username" name="username" type="text" value="{{ old('username') }}" placeholder="Masukkan email sekolah" autocomplete="username" required>
        </div>
        @error('username') <span class="field__err">{{ $message }}</span> @enderror
      </div>

      <div class="field">
        <label class="field__label" for="password">Kata Sandi</label>
        <div class="input-wrap">
          <span class="input-wrap__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          </span>
          <input id="password" name="password" type="password" placeholder="Masukkan kata sandi" autocomplete="current-password" required>
          <button type="button" class="input-wrap__btn" id="togglePwd" aria-label="Tampilkan kata sandi">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0Z" fill="#6f83a0"/><circle cx="12" cy="12" r="3" fill="#ffffff"/></svg>
          </button>
        </div>
        @error('password') <span class="field__err">{{ $message }}</span> @enderror
      </div>

      <button class="btn btn--primary btn--full" type="submit">Masuk</button>
    </form>

    <div class="login-forgot-wrap">
      <a class="login-forgot" href="{{ route('password.request') }}">Lupa kata sandi?</a>
    </div>
  </main>

  <footer class="login-footer">
    &copy; 2026 &bull; Sistem Laporan G7KAIH SMPN 21 Sinjai
  </footer>
</div>

<script>
document.getElementById('themeToggle')?.addEventListener('click', function () {
  var r = document.documentElement;
  var dark = r.getAttribute('data-theme') === 'dark';
  if (dark) { r.removeAttribute('data-theme'); localStorage.setItem('g7kaih-theme', 'light'); }
  else { r.setAttribute('data-theme', 'dark'); localStorage.setItem('g7kaih-theme', 'dark'); }
});
document.getElementById('togglePwd')?.addEventListener('click', function () {
  var inp = document.getElementById('password');
  inp.type = inp.type === 'password' ? 'text' : 'password';
});
</script>
</body>
</html>
