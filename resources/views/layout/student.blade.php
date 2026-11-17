<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Beranda Siswa') — G7KAIH</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/g7kaih-app.css') }}">
  <script>if (localStorage.getItem('g7kaih-theme') === 'dark') document.documentElement.setAttribute('data-theme', 'dark');</script>
</head>
<body>
@php $u = auth()->user(); @endphp

<header class="app-header">
  <div class="app-header__inner">
    <a class="brand" href="{{ route('student.dashboard') }}">
      <img class="brand__logo" src="{{ asset('images/logo-g7kaih.png') }}" alt="Logo G7KAIH" width="40" height="40">
      <span class="brand__text">
        <span class="brand__name">G7KAIH</span>
        <span class="brand__sub">SMPN 21 Sinjai</span>
      </span>
    </a>

    <nav class="app-nav" aria-label="Menu siswa">
      <a class="app-nav__link {{ request()->routeIs('student.dashboard', 'student.riwayat*') ? 'is-active' : '' }}" href="{{ route('student.dashboard') }}">Beranda</a>
      <a class="app-nav__link {{ request()->routeIs('student.laporan*') ? 'is-active' : '' }}" href="{{ route('student.laporan') }}">Laporan</a>
      <a class="app-nav__link {{ request()->routeIs('student.lencana*') ? 'is-active' : '' }}" href="{{ route('student.lencana') }}">Lencana</a>
      <a class="app-nav__link {{ request()->routeIs('student.profil*') ? 'is-active' : '' }}" href="{{ route('student.profil') }}">Profil</a>
    </nav>

    <div class="app-user">
      <button type="button" class="theme-circle" id="themeToggle" aria-label="Ubah tema" title="Ubah tema">
        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
      </button>
      <a href="{{ route('student.profil') }}" style="display:flex;align-items:center;gap:10px;">
        <img src="{{ asset('images/avatar-akram.jpg') }}" alt="{{ $u->name }}" width="40" height="40" style="width:40px;height:40px;border-radius:999px;object-fit:cover;flex:none;">
        <span class="app-user__meta">
          <span class="app-user__name">{{ $u->name }}</span>
          <span class="app-user__role">Siswa</span>
        </span>
      </a>
    </div>
  </div>
</header>

<main class="app-container">
  @if (session('ok'))
    <div class="alert alert--ok" role="status">{{ session('ok') }}</div>
  @endif

  @yield('content')
</main>

<footer class="app-footer">
  &copy; 2026 &bull; Sistem Laporan G7KAIH SMPN 21 Sinjai
</footer>

<nav class="bottom-nav" aria-label="Navigasi bawah siswa">
  <a class="bottom-nav__item {{ request()->routeIs('student.dashboard', 'student.riwayat*') ? 'is-active' : '' }}" href="{{ route('student.dashboard') }}">
    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
    Beranda
  </a>
  <a class="bottom-nav__item {{ request()->routeIs('student.laporan*') ? 'is-active' : '' }}" href="{{ route('student.laporan') }}">
    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
    Laporan
  </a>
  <a class="bottom-nav__item {{ request()->routeIs('student.lencana*') ? 'is-active' : '' }}" href="{{ route('student.lencana') }}">
    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
    Lencana
  </a>
  <a class="bottom-nav__item {{ request()->routeIs('student.profil*') ? 'is-active' : '' }}" href="{{ route('student.profil') }}">
    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
    Profil
  </a>
</nav>

<script>
document.getElementById('themeToggle')?.addEventListener('click', function () {
  var r = document.documentElement;
  var dark = r.getAttribute('data-theme') === 'dark';
  if (dark) { r.removeAttribute('data-theme'); localStorage.setItem('g7kaih-theme', 'light'); }
  else { r.setAttribute('data-theme', 'dark'); localStorage.setItem('g7kaih-theme', 'dark'); }
});
</script>
@stack('scripts')
</body>
</html>
