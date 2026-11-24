<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - Sistem Laporan G7KAIH</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @include('includes.admin._style')
    @stack('styles')
</head>
<body>
    @include('includes.admin._navbar')

    <main class="app-container">
        @yield('content')
    </main>

    @include('includes.admin._footer')

    <nav class="bottom-nav" aria-label="Navigasi bawah admin">
      <a class="bottom-nav__item {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}" href="{{ route('admin.dashboard') }}">
        <span data-i="layout-dashboard"></span>
        <span>Dashboard</span>
      </a>
      <a class="bottom-nav__item {{ request()->routeIs('akun.*') ? 'is-active' : '' }}" href="{{ route('akun.index') }}">
        <span data-i="users-round"></span>
        <span>Akun</span>
      </a>
      <a class="bottom-nav__item {{ request()->routeIs('admin.laporan') ? 'is-active' : '' }}" href="{{ route('admin.laporan') }}">
        <span data-i="chart-column"></span>
        <span>Laporan</span>
      </a>
      <button type="button" class="bottom-nav__item {{ request()->routeIs('admin.perwalian','admin.badge*','admin.pengaturan*') ? 'is-active' : '' }}" onclick="openOverlay('adminMoreSheet', this)" aria-haspopup="dialog">
        <span data-i="menu"></span>
        <span>Lainnya</span>
      </button>
    </nav>

    <div id="adminMoreSheet" class="sheet-backdrop" role="dialog" aria-modal="true" aria-labelledby="adminMoreTitle" onclick="if(event.target===this)closeOverlay('adminMoreSheet')">
      <div class="sheet-panel">
        <div class="row" style="justify-content:space-between;">
          <h2 id="adminMoreTitle">Menu Admin Lainnya</h2>
          <button type="button" class="btn o s" onclick="closeOverlay('adminMoreSheet')">Tutup</button>
        </div>
        <a class="sheet-link {{ request()->routeIs('admin.perwalian') ? 'is-active' : '' }}" href="{{ route('admin.perwalian') }}"><span data-i="school"></span>Atur Perwalian</a>
        <a class="sheet-link {{ request()->routeIs('admin.badge*') ? 'is-active' : '' }}" href="{{ route('admin.badge') }}"><span data-i="award"></span>Badge Pencapaian</a>
        <a class="sheet-link {{ request()->routeIs('admin.pengaturan*') ? 'is-active' : '' }}" href="{{ route('admin.pengaturan') }}"><span data-i="settings"></span>Pengaturan Admin</a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="sheet-link" style="width:100%;color:var(--badtx);background:var(--badbg);"><span data-i="log-out"></span>Keluar Akun</button>
        </form>
      </div>
    </div>

    <div class="toast" id="toast" role="status" aria-live="polite"></div>

    @include('includes.admin._js')
    @stack('scripts')
</body>
</html>
