<aside>
    <div class="brand">
        <img src="{{ asset('images/logo-g7kaih.png') }}" alt="Logo G7KAIH" width="36" height="36" style="width:36px;height:36px;border-radius:50%;object-fit:contain;padding:2px;background:#fff;overflow:hidden;flex:none;">
        <div><b>G7KAIH</b><small>SMPN 21 Sinjai</small></div>
    </div>
    <nav>
        <a class="nv {{ request()->is('admin') || request()->is('dashboard*') ? 'on' : '' }}" href="{{ route('admin.dashboard') }}"><span data-i="layout-dashboard"></span><span>Dashboard</span></a>
        <a class="nv {{ request()->is('akun*') ? 'on' : '' }}" href="{{ route('akun.index') }}"><span data-i="users-round"></span><span>Kelola Akun &amp; Pengguna</span></a>
        <a class="nv {{ request()->is('perwalian*') ? 'on' : '' }}" href="{{ route('admin.perwalian') }}"><span data-i="school"></span><span>Atur Perwalian</span></a>
        <a class="nv {{ request()->is('badge*') ? 'on' : '' }}" href="{{ route('admin.badge') }}"><span data-i="award"></span><span>Badge Pencapaian</span></a>
        <a class="nv {{ request()->is('laporan*') ? 'on' : '' }}" href="{{ route('admin.laporan') }}"><span data-i="chart-column"></span><span>Pemantauan Keseluruhan</span></a>
        <a class="nv {{ request()->is('pengaturan*') ? 'on' : '' }}" href="{{ route('admin.pengaturan') }}"><span data-i="settings"></span><span>Pengaturan</span></a>
    </nav>
    <div class="sch"><span>SMPN 21 Sinjai</span><small>Tahun ajaran 2026 / 2027</small></div>
</aside>
