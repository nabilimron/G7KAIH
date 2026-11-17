@php $u = auth()->user(); @endphp
<header>
  <div style="display:flex;align-items:center;gap:10px;min-width:0;">
    <button type="button" class="menu-btn" onclick="document.body.classList.toggle('nav-open')" aria-label="Buka menu navigasi">
      <span data-i="menu"></span>
    </button>
    <b style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">Sistem Laporan G7KAIH</b>
  </div>
  <div class="acc">
    <span data-i="bell" aria-hidden="true"></span>
    <div class="av">{{ $u ? $u->inisial() : 'AD' }}</div>
    <div class="acc-meta"><strong>{{ $u->name ?? 'Admin Sekolah' }}</strong><small>{{ $u ? $u->labelRole() : 'Admin' }}</small></div>
    <form method="POST" action="{{ route('logout') }}" style="margin-left:6px;">
      @csrf
      <button type="submit" style="padding:6px 10px;border-radius:8px;background:#fdecee;color:#e34557;font-size:11px;font-weight:700;cursor:pointer;">Keluar</button>
    </form>
  </div>
</header>
<div class="mob-subbar">
  <div><strong>SMPN 21 Sinjai</strong><small>Tahun ajaran 2026 / 2027</small></div>
  <div style="text-align:right;"><strong>{{ $u->name ?? 'Admin Sekolah' }}</strong><small>{{ $u ? $u->labelRole() : 'Admin' }}</small></div>
</div>
