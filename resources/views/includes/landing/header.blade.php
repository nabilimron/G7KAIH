<header class="site-header" id="beranda">
      <a class="brand" href="#beranda" aria-label="G7KAIH SMPN 21 Sinjai">
        <img class="brand__logo" src="{{ asset('images/logo-g7kaih.png') }}" alt="Logo G7KAIH" width="40" height="40">
        <span class="brand__text">
          <span class="brand__name">G7KAIH</span>
          <span class="brand__sub">SMPN 21 Sinjai</span>
        </span>
      </a>

      <nav class="main-nav" aria-label="Navigasi utama">
        <a href="#beranda" class="is-active" aria-current="page">Beranda</a>
        <a href="#tentang">Tentang</a>
        <a href="#fitur">Fitur</a>
        <a href="#kontak">Kontak</a>
      </nav>

      <div class="header-actions">
        <button type="button" class="theme-toggle" id="themeToggle" aria-label="Ubah tema terang atau gelap" title="Ubah tema">
          <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
          </svg>
        </button>
        @auth
          <a class="btn btn--login" href="{{ match (auth()->user()->role) { 'siswa' => route('student.dashboard'), 'guru_wali' => route('teacher.dashboard'), default => route('admin.dashboard') } }}">Dashboard</a>
        @else
          <a class="btn btn--login" href="{{ route('login') }}">Login</a>
        @endauth
      </div>
    </header>