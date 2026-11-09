<aside>
    <div class="brand">
        <svg width="29" height="29" viewBox="0 0 29 29"><circle cx="10" cy="10" r="7" fill="#17b979"/><circle cx="19" cy="10" r="7" fill="#247ef2"/><circle cx="10" cy="19" r="7" fill="#efbd37"/><circle cx="19" cy="19" r="7" fill="#e34557"/></svg>
        <div><b>G7KAIH</b><small>SMPN 21 Sinjai</small></div>
    </div>
    <nav>
        <a class="nv {{ request()->is('/dashboard*') ? 'on' : '' }}" href="{{ url('/dashboard') }}"><span data-i="layout-dashboard"></span><span>Dashboard</span></a>
        <a class="nv {{ request()->is('/akun*') ? 'on' : '' }}" href="{{ url('/akun') }}"><span data-i="users-round"></span><span>Kelola Akun & Pengguna</span></a>
        <a class="nv {{ request()->is('/perwalian*') ? 'on' : '' }}" href="{{ url('/perwalian') }}"><span data-i="school"></span><span>Atur Perwalian</span></a>
        <a class="nv {{ request()->is('/badge*') ? 'on' : '' }}" href="{{ url('/badge') }}"><span data-i="award"></span><span>Badge Pencapaian</span></a>
        <a class="nv {{ request()->is('/laporan*') ? 'on' : '' }}" href="{{ url('/laporan') }}"><span data-i="chart-column"></span><span>Pemantauan Keseluruhan</span></a>
        <a class="nv {{ request()->is('/pengaturan*') ? 'on' : '' }}" href="{{ url('/pengaturan') }}"><span data-i="settings"></span><span>Pengaturan</span></a>
    </nav>
    <div class="sch"><span>SMPN 21 Sinjai</span><small>Tahun ajaran 2025 / 2026</small></div>
</aside>