@extends('layout.admin')
@section('title', 'Kelola Akun & Pengguna')

@section('content')
<section class="view" id="akun">
  <div class="top">
    <div>
      <h1>Kelola Akun &amp; Pengguna</h1>
      <p class="sub">Kelola akses guru wali dan siswa SMPN 21 Sinjai.</p>
    </div>
    <a class="btn" href="{{ route('akun.create') }}"><span data-i="plus"></span>Tambah Akun</a>
  </div>

  <div class="card sh">
    <div class="tabs">
      <a class="tab {{ $role === 'guru_wali' ? 'on' : '' }}" href="{{ route('akun.index', ['role' => 'guru_wali']) }}">Guru &amp; Staf</a>
      <a class="tab {{ $role === 'siswa' ? 'on' : '' }}" href="{{ route('akun.index', ['role' => 'siswa']) }}">Siswa</a>
    </div>

    <form method="GET" class="row" style="gap:12px;flex-wrap:wrap;">
      <input type="hidden" name="role" value="{{ $role }}">
      <label class="ctl" style="flex:1;min-width:200px;">
        <input name="q" value="{{ request('q') }}" placeholder="Cari nama atau username..." aria-label="Cari">
        <span data-i="search"></span>
      </label>
      <label class="ctl" style="flex:1;min-width:170px;">
        <select name="status" onchange="this.form.submit()" aria-label="Status">
          <option value="">Semua Status</option>
          <option value="aktif" @selected(request('status') === 'aktif')>Aktif</option>
          <option value="nonaktif" @selected(request('status') === 'nonaktif')>Nonaktif</option>
        </select>
        <span data-i="chevron-down"></span>
      </label>
    </form>

    <div class="tinted-list">
      @forelse ($users as $u)
        @php $aktif = $u->isAktif(); @endphp
        <div class="tinted-row tinted-row--{{ $aktif ? 'ok' : 'bad' }}">
          <div class="tinted-row__id">
            <span class="av" aria-hidden="true">{{ $u->inisial() }}</span>
            <div>
              <div class="tinted-row__name">{{ $u->name }}</div>
              <div class="tinted-row__sub">{{ $u->username }} &bull; {{ $u->labelRole() }}</div>
            </div>
          </div>

          <span class="pill pill--{{ $aktif ? 'ok' : 'bad' }}">{{ ucfirst($u->status) }}</span>

          <div class="ic">
            <a class="e" href="{{ route('akun.edit', $u) }}" aria-label="Ubah {{ $u->name }}"><span data-i="pencil"></span></a>
            <form method="POST" action="{{ route('akun.destroy', $u) }}"
                  onsubmit="return confirm(@js('Hapus akun ' . $u->name . '?'))" style="display:inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="d" aria-label="Hapus {{ $u->name }}"><span data-i="trash"></span></button>
            </form>
          </div>
        </div>
      @empty
        <div style="text-align:center;color:var(--mut);padding:28px;">Tidak ada akun yang cocok.</div>
      @endforelse
    </div>

    {{ $users->links() }}
  </div>

  <div class="card sh">
    <div>
      <h2>Reset Password</h2>
      <p class="ps">Pilih akun yang memerlukan pengaturan ulang password ke sandi standar.</p>
    </div>
    <form method="POST" action="{{ route('akun.reset-password') }}" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;">
      @csrf
      <div class="fld" style="min-width:220px;">
        <label for="rp_user">Username / Email Sekolah</label>
        <div class="ctl"><input id="rp_user" name="username" required placeholder="Masukkan username atau email sekolah"></div>
      </div>
      <button type="submit" class="btn"><span data-i="key-round"></span>Reset Password</button>
    </form>
  </div>
</section>
@endsection

@push('scripts')
<script>
  @if (session('ok')) toast(@json(session('ok'))); @endif
  @if (session('err')) toast(@json(session('err'))); @endif
</script>
@endpush
