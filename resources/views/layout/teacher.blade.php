<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Guru Wali') - Sistem Laporan G7KAIH</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @include('includes.admin._style')
    @stack('styles')
</head>
<body>
@php $u = auth()->user(); @endphp

<header class="app-header">
  <div class="app-header__inner">
    <a class="brand" href="{{ route('teacher.dashboard') }}">
      <img class="brand__logo" src="{{ asset('images/logo-g7kaih.png') }}" alt="Logo G7KAIH" width="40" height="40">
      <span class="brand__text">
        <span class="brand__name">G7KAIH</span>
        <span class="brand__sub">SMPN 21 Sinjai</span>
      </span>
    </a>

    <nav class="app-nav" aria-label="Menu guru wali">
      <a class="app-nav__link {{ request()->routeIs('teacher.dashboard', 'teacher.detail-siswa') ? 'is-active' : '' }}" href="{{ route('teacher.dashboard') }}">Dashboard</a>
      <a class="app-nav__link {{ request()->routeIs('teacher.verifikasi', 'teacher.detail-laporan') ? 'is-active' : '' }}" href="{{ route('teacher.verifikasi') }}">Verifikasi Laporan</a>
      <a class="app-nav__link {{ request()->routeIs('teacher.rekapitulasi') ? 'is-active' : '' }}" href="{{ route('teacher.rekapitulasi') }}">Rekapitulasi Data</a>
      <a class="app-nav__link {{ request()->routeIs('teacher.profil') ? 'is-active' : '' }}" href="{{ route('teacher.profil') }}">Profil</a>
    </nav>

    <div class="app-user">
      <button type="button" class="theme-circle" onclick="toggleTheme()" aria-label="Ganti tema terang atau gelap" title="Ganti Tema">
        <span data-i="moon"></span>
      </button>
      <a href="{{ route('teacher.profil') }}" style="display:flex;align-items:center;gap:10px;">
        <div class="av" aria-hidden="true">{{ $u ? $u->inisial() : 'GW' }}</div>
        <span class="app-user__meta">
          <span class="app-user__name">{{ $u->name ?? 'Guru Wali' }}</span>
          <span class="app-user__role">Guru Wali</span>
        </span>
      </a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout-btn">Keluar</button>
      </form>
    </div>
  </div>
</header>

<main class="app-container">
    @yield('content')
</main>

@include('includes.admin._footer')

<nav class="bottom-nav" aria-label="Navigasi bawah guru wali">
  <a class="bottom-nav__item {{ request()->routeIs('teacher.dashboard', 'teacher.detail-siswa') ? 'is-active' : '' }}" href="{{ route('teacher.dashboard') }}">
    <span data-i="layout-dashboard"></span>
    <span>Dashboard</span>
  </a>
  <a class="bottom-nav__item {{ request()->routeIs('teacher.verifikasi', 'teacher.detail-laporan') ? 'is-active' : '' }}" href="{{ route('teacher.verifikasi') }}">
    <span data-i="file-check"></span>
    <span>Verifikasi</span>
  </a>
  <a class="bottom-nav__item {{ request()->routeIs('teacher.rekapitulasi') ? 'is-active' : '' }}" href="{{ route('teacher.rekapitulasi') }}">
    <span data-i="chart-column"></span>
    <span>Rekap</span>
  </a>
  <a class="bottom-nav__item {{ request()->routeIs('teacher.profil') ? 'is-active' : '' }}" href="{{ route('teacher.profil') }}">
    <span data-i="user-round"></span>
    <span>Profil</span>
  </a>
</nav>

<div class="toast" id="toast" role="status" aria-live="polite"></div>
@include('includes.admin._js')
@stack('scripts')
</body>
</html>
