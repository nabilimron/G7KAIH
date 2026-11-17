@extends('layout.admin')
@section('title', 'Kelola Akun & Pengguna')

@section('content')
<section class="view on" id="akun">
 <div class="top">
  <div><h1>Kelola Akun &amp; Pengguna</h1><p class="sub">Kelola akses guru wali dan siswa SMPN 21 Sinjai.</p></div>
  <a class="btn" href="{{ route('akun.create') }}"><span data-i="plus"></span>Tambah Akun</a>
 </div>

 <div class="card sh">
  {{-- TAB --}}
  <div class="tabs">
   <a class="tab {{ $role === 'guru_wali' ? 'on' : '' }}" href="{{ route('akun.index', ['role' => 'guru_wali']) }}">Guru &amp; Staf</a>
   <a class="tab {{ $role === 'siswa' ? 'on' : '' }}" href="{{ route('akun.index', ['role' => 'siswa']) }}">Siswa</a>
  </div>

  {{-- CARI & FILTER STATUS --}}
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

  {{-- TABEL --}}
  <div class="tw"><table>
   <thead><tr><th style="width:28px">No</th><th>Nama</th><th>Username</th><th>Role</th><th>Status</th><th style="width:72px">Aksi</th></tr></thead>
   <tbody>
   @forelse ($users as $u)
    <tr>
     <td>{{ $users->firstItem() + $loop->index }}</td>
     <td><div class="nm"><span>{{ $u->name }}</span><span class="av" aria-hidden="true">{{ $u->inisial() }}</span></div></td>
     <td>{{ $u->username }}</td>
     <td>{{ $u->labelRole() }}</td>
     <td>
      <span style="display:inline-block;padding:4px 10px;border-radius:100px;font-size:11px;font-weight:700;color:#fff;background:{{ $u->isAktif() ? '#07805d' : '#c52d49' }}">
       {{ ucfirst($u->status) }}
      </span>
     </td>
     <td><div class="ic">
      <a class="e" href="{{ route('akun.edit', $u) }}" aria-label="Ubah {{ $u->name }}"><span data-i="pencil"></span></a>
      <form method="POST" action="{{ route('akun.destroy', $u) }}"
            onsubmit="return confirm(@js('Hapus akun ' . $u->name . '?'))" style="display:inline">
       @csrf
       @method('DELETE')
       <button class="d" aria-label="Hapus {{ $u->name }}"><span data-i="trash"></span></button>
      </form>
     </div></td>
    </tr>
   @empty
    <tr><td colspan="6" style="text-align:center;color:var(--mut);padding:28px">Tidak ada akun yang cocok.</td></tr>
   @endforelse
   </tbody>
  </table></div>

  {{ $users->links() }}
 </div>

 {{-- Card 2: Reset Password (Figma 434:2719) --}}
 <div class="card bd">
  <div>
   <h2>Reset Password</h2>
   <p class="ps">Pilih akun yang memerlukan pengaturan ulang password.</p>
  </div>
  <form method="POST" action="{{ route('akun.reset-password') }}" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;">
   @csrf
   <div class="fld" style="min-width:220px;">
    <label for="rp_user">Username</label>
    <div class="ctl"><input id="rp_user" name="username" required placeholder="Masukkan username"></div>
   </div>
   <button type="submit" class="btn"><span data-i="key-round"></span>Reset Password</button>
  </form>
 </div>
</section>
@endsection

@push('scripts')
<script>
 paint();
 @if (session('ok')) toast(@json(session('ok'))); @endif
 @if (session('err')) toast(@json(session('err'))); @endif
</script>
@endpush
