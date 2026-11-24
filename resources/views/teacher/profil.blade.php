@extends('layout.teacher')
@section('title', 'Profil Guru Wali')

@section('content')
<section class="view">
  <div class="top">
    <div>
      <h1>Profil Saya</h1>
      <p class="sub">Informasi identitas guru wali dan pengaturan akun Anda.</p>
    </div>
  </div>

  <div class="card sh">
    <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
      <div class="av" style="width:64px;height:64px;font-size:20px;">{{ $user ? $user->inisial() : 'GW' }}</div>
      <div>
        <h2 style="font-size:18px;">{{ $guru->nama_guru ?? ($user->name ?? 'Guru Wali') }}</h2>
        <p class="ps">Guru Wali Kelas {{ $kelasWali }} &bull; {{ $jumlahSiswa }} Siswa Perwalian</p>
      </div>
    </div>

    <div class="g2 eq" style="padding-top:8px;border-top:1px solid var(--line-soft);">
      <div>
        <small style="color:var(--mut);">Username / Email Sekolah</small>
        <div style="font-weight:700;margin-top:4px;">{{ $user->username ?? '-' }}</div>
      </div>
      <div>
        <small style="color:var(--mut);">Tahun Ajaran Aktif</small>
        <div style="font-weight:700;margin-top:4px;">{{ $semester->tahun_ajaran ?? '2026/2027' }} ({{ $semester->nama_semester ?? 'Ganjil' }})</div>
      </div>
    </div>
  </div>

  <div class="card sh">
    <h2>Perbarui Informasi Profil</h2>
    <form method="POST" action="{{ route('teacher.profil.update') }}" style="display:flex;flex-direction:column;gap:16px;">
      @csrf @method('PUT')
      <div class="g2 eq">
        <div class="fld">
          <label for="gw_nama">Nama Guru Wali</label>
          <div class="ctl"><input id="gw_nama" name="nama_guru" value="{{ old('nama_guru', $guru->nama_guru ?? ($user->name ?? '')) }}" required></div>
        </div>
        <div class="fld">
          <label for="gw_hp">Nomor Telepon</label>
          <div class="ctl"><input id="gw_hp" name="no_hp" value="{{ old('no_hp', $guru->no_hp ?? '') }}" placeholder="08xxxxxxxxxx"></div>
        </div>
      </div>
      <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;">
        <button type="submit" class="btn"><span data-i="save"></span>Simpan Perubahan</button>
      </div>
    </form>

    <form method="POST" action="{{ route('logout') }}" style="padding-top:12px;border-top:1px solid var(--line-soft);">
      @csrf
      <button type="submit" class="btn bad"><span data-i="log-out"></span>Keluar Akun</button>
    </form>
  </div>
</section>
@endsection

@push('scripts')
<script>
  @if (session('ok')) toast(@json(session('ok'))); @endif
</script>
@endpush
