<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Guru Wali') — Sistem Laporan G7KAIH</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @include('includes.admin._style')
</head>
<body>
@php $u = auth()->user(); @endphp
<div class="drawer-backdrop" onclick="document.body.classList.remove('nav-open')" aria-hidden="true"></div>
<aside>
    <div class="brand">
        <img src="{{ asset('images/logo-g7kaih.png') }}" alt="Logo G7KAIH" width="36" height="36" style="width:36px;height:36px;border-radius:50%;object-fit:contain;padding:2px;background:#fff;overflow:hidden;flex:none;">
        <div><b>G7KAIH</b><small>SMPN 21 Sinjai</small></div>
    </div>
    <nav>
        <a class="nv {{ request()->routeIs('teacher.dashboard', 'teacher.detail-siswa') ? 'on' : '' }}" href="{{ route('teacher.dashboard') }}"><span data-i="layout-dashboard"></span><span>Dashboard</span></a>
        <a class="nv {{ request()->routeIs('teacher.verifikasi', 'teacher.detail-laporan') ? 'on' : '' }}" href="{{ route('teacher.verifikasi') }}"><span data-i="file-check"></span><span>Verifikasi Laporan</span></a>
        <a class="nv {{ request()->routeIs('teacher.rekapitulasi') ? 'on' : '' }}" href="{{ route('teacher.rekapitulasi') }}"><span data-i="chart-column"></span><span>Rekapitulasi Data</span></a>
        <button type="button" class="nv" onclick="document.getElementById('teacherProfileModal').style.display='flex'"><span data-i="user-round"></span><span>Profil</span></button>
    </nav>
    <div class="sch"><span>SMPN 21 Sinjai</span><small>Tahun ajaran 2026 / 2027</small></div>
</aside>

<div class="area">
    <header>
        <div style="display:flex;align-items:center;gap:10px;min-width:0;">
            <button type="button" class="menu-btn" onclick="document.body.classList.toggle('nav-open')" aria-label="Buka menu navigasi">
                <span data-i="menu"></span>
            </button>
            <b style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">Sistem Laporan G7KAIH</b>
        </div>
        <div class="acc">
            <span data-i="bell" aria-hidden="true"></span>
            <div class="av">{{ $u ? $u->inisial() : 'GW' }}</div>
            <div class="acc-meta"><strong>{{ $u->name ?? 'Guru Wali' }}</strong><small>Guru Wali</small></div>
            <form method="POST" action="{{ route('logout') }}" style="margin-left:6px;">
                @csrf
                <button type="submit" style="padding:6px 10px;border-radius:8px;background:#fdecee;color:#e34557;font-size:11px;font-weight:700;cursor:pointer;">Keluar</button>
            </form>
        </div>
    </header>
    <div class="mob-subbar">
        <div><strong>SMPN 21 Sinjai</strong><small>Tahun ajaran 2026 / 2027</small></div>
        <div style="text-align:right;"><strong>{{ $u->name ?? 'Guru Wali' }}</strong><small>Guru Wali</small></div>
    </div>

    <main>
        @yield('content')
    </main>

    @include('includes.admin._footer')
</div>

{{-- Modal Profil Guru Wali --}}
<div id="teacherProfileModal" style="display:none;position:fixed;inset:0;z-index:70;background:rgba(16,46,84,.45);align-items:center;justify-content:center;padding:16px;">
    <div class="card" style="width:100%;max-width:420px;">
        <h2>Profil Guru Wali</h2>
        <form method="POST" action="{{ route('teacher.profil.update') }}" style="display:flex;flex-direction:column;gap:14px;">
            @csrf @method('PUT')
            <div class="fld">
                <label for="gw_nama">Nama Guru Wali</label>
                <div class="ctl"><input id="gw_nama" name="nama_guru" value="{{ $guru->nama_guru ?? ($u->name ?? '') }}" required></div>
            </div>
            <div class="fld">
                <label for="gw_hp">Nomor Telepon</label>
                <div class="ctl"><input id="gw_hp" name="no_hp" value="{{ $guru->no_hp ?? '' }}"></div>
            </div>
            <div style="display:flex;justify-content:flex-end;gap:10px;">
                <button type="button" class="btn o" onclick="document.getElementById('teacherProfileModal').style.display='none'">Tutup</button>
                <button type="submit" class="btn">Simpan Profil</button>
            </div>
        </form>
    </div>
</div>

<div class="toast" id="toast" role="status"></div>
@include('includes.admin._js')
@stack('scripts')
</body>
</html>
