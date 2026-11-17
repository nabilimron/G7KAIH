<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lupa Kata Sandi — G7KAIH SMPN 21 Sinjai</title>
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
    <span class="login-motto">Kolaborasi untuk Generasi Hebat</span>
  </header>

  <main class="login-card">
    <h1 class="login-card__title">Ajukan Bantuan</h1>
    <p class="login-card__sub">Masukkan username atau NISN Anda untuk pemulihan kata sandi oleh admin sekolah.</p>

    @if (session('bantuan_ok'))
      <div class="alert alert--ok">{{ session('bantuan_ok') }}</div>
    @endif

    <form method="POST" action="{{ route('password.request.post') }}">
      @csrf
      <div class="field">
        <label class="field__label" for="username">Username atau NISN</label>
        <div class="input-wrap">
          <input id="username" name="username" type="text" value="{{ old('username') }}" placeholder="Contoh: akram / 0091234567" required>
        </div>
        @error('username') <span class="field__err">{{ $message }}</span> @enderror
      </div>

      <div class="field">
        <label class="field__label" for="catatan">Keterangan (Opsional)</label>
        <div class="input-wrap">
          <textarea id="catatan" name="catatan" rows="2" placeholder="Contoh: Kelas IX B, lupa kata sandi">{{ old('catatan') }}</textarea>
        </div>
      </div>

      <button class="btn btn--primary btn--full" type="submit">Kirim Permintaan Bantuan</button>
    </form>

    <a class="login-forgot" href="{{ route('login') }}">&larr; Kembali ke Masuk</a>
  </main>

  <footer class="login-footer">
    &copy; 2026 &bull; Sistem Laporan G7KAIH SMPN 21 Sinjai
  </footer>
</div>
</body>
</html>
