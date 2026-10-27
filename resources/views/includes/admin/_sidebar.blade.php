<aside>
    <div class="brand">
        <svg width="29" height="29" viewBox="0 0 29 29"><circle cx="10" cy="10" r="7" fill="#17b979"/><circle cx="19" cy="10" r="7" fill="#247ef2"/><circle cx="10" cy="19" r="7" fill="#efbd37"/><circle cx="19" cy="19" r="7" fill="#e34557"/></svg>
        <div><b>G7KAIH</b><small>SMPN 21 Sinjai</small></div>
    </div>
    <nav>
        <a class="nv {{ request()->is('admin/dashboard*') ? 'on' : '' }}" href="{{ url('admin/dashboard') }}"><span data-i="layout-dashboard"></span><span>Dashboard</span></a>
        <a class="nv {{ request()->is('admin/akun*') ? 'on' : '' }}" href="{{ url('admin/akun') }}"><span data-i="users-round"></span><span>Kelola Akun & Pengguna</span></a>
        <a class="nv {{ request()->is('admin/perwalian*') ? 'on' : '' }}" href="{{ url('admin/perwalian') }}"><span data-i="school"></span><span>Atur Perwalian</span></a>
        <a class="nv {{ request()->is('admin/badge*') ? 'on' : '' }}" href="{{ url('admin/badge') }}"><span data-i="award"></span><span>Badge Pencapaian</span></a>
        <a class="nv {{ request()->is('admin/laporan*') ? 'on' : '' }}" href="{{ url('admin/laporan') }}"><span data-i="chart-column"></span><span>Pemantauan Keseluruhan</span></a>
        <a class="nv {{ request()->is('admin/pengaturan*') ? 'on' : '' }}" href="{{ url('admin/pengaturan') }}"><span data-i="settings"></span><span>Pengaturan</span></a>
    </nav>
    <div class="sch"><span>SMPN 21 Sinjai</span><small>Tahun ajaran 2025 / 2026</small></div>
</aside>
