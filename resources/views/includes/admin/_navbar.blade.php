@php $u = auth()->user(); @endphp
<header class="app-header">
  <div class="app-header__inner">
    <a class="brand" href="{{ route('admin.dashboard') }}">
      <img class="brand__logo" src="{{ asset('images/logo-g7kaih.png') }}" alt="Logo G7KAIH" width="40" height="40">
      <span class="brand__text">
        <span class="brand__name">G7KAIH</span>
        <span class="brand__sub">SMPN 21 Sinjai</span>
      </span>
    </a>

    <nav class="app-nav" aria-label="Menu admin">
      <a class="app-nav__link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
      <a class="app-nav__link {{ request()->routeIs('akun.*') ? 'is-active' : '' }}" href="{{ route('akun.index') }}">Akun</a>
      <a class="app-nav__link {{ request()->routeIs('admin.perwalian') ? 'is-active' : '' }}" href="{{ route('admin.perwalian') }}">Perwalian</a>
      <a class="app-nav__link {{ request()->routeIs('admin.badge*') ? 'is-active' : '' }}" href="{{ route('admin.badge') }}">Badge</a>
      <a class="app-nav__link {{ request()->routeIs('admin.laporan') ? 'is-active' : '' }}" href="{{ route('admin.laporan') }}">Laporan</a>
      <a class="app-nav__link {{ request()->routeIs('admin.pengaturan*') ? 'is-active' : '' }}" href="{{ route('admin.pengaturan') }}">Pengaturan</a>
    </nav>

    <div class="app-user">
      <button type="button" class="theme-circle" onclick="toggleTheme()" aria-label="Ganti tema terang atau gelap" title="Ganti Tema">
        <span data-i="moon"></span>
      </button>
      <div class="av" aria-hidden="true">{{ $u ? $u->inisial() : 'AD' }}</div>
      <div class="app-user__meta">
        <span class="app-user__name">{{ $u->name ?? 'Admin Sekolah' }}</span>
        <span class="app-user__role">{{ $u ? $u->labelRole() : 'Admin Sekolah' }}</span>
      </div>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout-btn">Keluar</button>
      </form>
    </div>
  </div>
</header>
