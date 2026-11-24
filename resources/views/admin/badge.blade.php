@extends('layout.admin')
@section('title', 'Badge Pencapaian')

@section('content')
<section class="view">
  <div class="top">
    <div>
      <h1>Atur Badge Pencapaian</h1>
      <p class="sub">Kelola syarat pencapaian dan badge untuk kebiasaan baik siswa.</p>
    </div>
  </div>

  <div class="card sh">
    <h2>Pengaturan Pencapaian</h2>
    <div class="opt">
      <div>
        <b>Berikan badge secara otomatis</b>
        <small>Badge diberikan ketika syarat terpenuhi dari laporan yang disetujui guru wali.</small>
      </div>
      <label class="sw">
        <input type="checkbox" id="autoBadgeToggle" checked aria-label="Berikan badge secara otomatis">
        <s></s>
      </label>
    </div>
    <div class="note">
      <span data-i="shield-check"></span>
      <span>Hanya laporan disetujui yang dihitung. Laporan menunggu atau ditolak tidak menambah kemajuan badge.</span>
    </div>
    <div style="display:flex;justify-content:flex-end;">
      <button type="button" class="btn" onclick="toast('Pengaturan pencapaian badge disimpan.')"><span data-i="save"></span>Simpan Pengaturan</button>
    </div>
  </div>

  @php
    $badgeColors = ['#17B979', '#E34557', '#238CE2', '#EFBD37', '#34B6CA', '#2B64B7'];
    $badgeIcons = ['sunrise', 'heart-handshake', 'book-open', 'clipboard-check', 'bike', 'award'];
  @endphp
  <div class="card sh">
    <div class="top">
      <div>
        <h2>Daftar Badge</h2>
        <p class="ps">{{ $badges->count() }} badge aktif untuk siswa</p>
      </div>
      <button type="button" class="btn" onclick="openOverlay('addBadgeModal', this)">
        <span data-i="plus"></span>Tambah Badge
      </button>
    </div>

    <div class="tinted-list">
      @forelse ($badges as $idx => $b)
        @php
          $bg = $badgeColors[$idx % count($badgeColors)];
          $ico = $badgeIcons[$idx % count($badgeIcons)];
        @endphp
        <div class="tinted-row tinted-row--soft">
          <div class="tinted-row__id">
            <span class="bi" style="background:{{ $bg }}"><span data-i="{{ $ico }}"></span></span>
            <div>
              <div class="tinted-row__name">{{ $b->nama }}</div>
              <div class="tinted-row__sub">{{ $b->deskripsi }} &bull; Target: {{ $b->syarat }}</div>
            </div>
          </div>
          <span class="pill pill--ok">Aktif</span>
          <div class="ic">
            <button type="button" class="e" aria-label="Ubah {{ $b->nama }}" onclick='openEditBadge(@json($b->id_badge), @json($b->nama), @json($b->deskripsi), @json($b->syarat), this)'>
              <span data-i="pencil"></span>
            </button>
            <form method="POST" action="{{ route('admin.badge.destroy', $b) }}" onsubmit="return confirm('Hapus badge ini?')" style="display:inline;">
              @csrf @method('DELETE')
              <button type="submit" class="d" aria-label="Hapus {{ $b->nama }}"><span data-i="trash"></span></button>
            </form>
          </div>
        </div>
      @empty
        <div style="text-align:center;color:var(--mut);padding:24px;">Belum ada badge terdaftar.</div>
      @endforelse
    </div>

    <div class="lg">
      <div>
        <h3 style="font-size:14px;font-weight:700;margin-bottom:4px;">Pengaturan Logo Badge</h3>
        <p class="ps" style="margin-top:0;">Pilih logo solid untuk setiap badge agar tampilan konsisten dan mudah dikenali.</p>
      </div>
      <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:16px;align-items:start;">
        <div>
          <div style="font-size:12px;font-weight:600;margin-bottom:10px;">Logo Badge</div>
          <div style="display:flex;flex-wrap:wrap;gap:12px;max-width:230px;">
            @foreach ($badgeColors as $idx => $col)
              <span class="bi" style="background:{{ $col }};width:44px;height:44px;"><span data-i="{{ $badgeIcons[$idx] }}"></span></span>
            @endforeach
          </div>
        </div>
        <div>
          <div style="font-size:12px;font-weight:600;margin-bottom:10px;">Aksi Logo</div>
          <button type="button" class="btn o s" onclick="openOverlay('logoModal', this)">Ubah logo</button>
        </div>
      </div>
    </div>
  </div>
</section>

<div id="addBadgeModal" class="modal-backdrop" role="dialog" aria-modal="true" aria-labelledby="addBadgeTitle" onclick="if(event.target===this)closeOverlay('addBadgeModal')">
  <div class="card" style="width:100%;max-width:440px;">
    <h2 id="addBadgeTitle">Tambah Badge Baru</h2>
    <form method="POST" action="{{ route('admin.badge.store') }}" style="display:flex;flex-direction:column;gap:12px;">
      @csrf
      <div class="fld"><label for="add_nama">Nama Badge</label><div class="ctl"><input id="add_nama" name="nama" required placeholder="Contoh: Pejuang Pagi"></div></div>
      <div class="fld"><label for="add_desc">Deskripsi</label><div class="ctl"><input id="add_desc" name="deskripsi" required placeholder="Keterangan pencapaian"></div></div>
      <div class="fld"><label for="add_syarat">Target Pencapaian</label><div class="ctl"><input id="add_syarat" name="syarat" required placeholder="Contoh: 7 hari laporan"></div></div>
      <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:4px;">
        <button type="button" class="btn o" onclick="closeOverlay('addBadgeModal')">Batal</button>
        <button type="submit" class="btn">Simpan Badge</button>
      </div>
    </form>
  </div>
</div>

<div id="editBadgeModal" class="modal-backdrop" role="dialog" aria-modal="true" aria-labelledby="editBadgeTitle" onclick="if(event.target===this)closeOverlay('editBadgeModal')">
  <div class="card" style="width:100%;max-width:440px;">
    <h2 id="editBadgeTitle">Ubah Badge Pencapaian</h2>
    <form id="editBadgeForm" method="POST" style="display:flex;flex-direction:column;gap:12px;">
      @csrf @method('PUT')
      <div class="fld"><label for="eb_nama">Nama Badge</label><div class="ctl"><input id="eb_nama" name="nama" required></div></div>
      <div class="fld"><label for="eb_desc">Deskripsi</label><div class="ctl"><input id="eb_desc" name="deskripsi" required></div></div>
      <div class="fld"><label for="eb_syarat">Target Pencapaian</label><div class="ctl"><input id="eb_syarat" name="syarat" required></div></div>
      <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:4px;">
        <button type="button" class="btn o" onclick="closeOverlay('editBadgeModal')">Batal</button>
        <button type="submit" class="btn">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<div id="logoModal" class="modal-backdrop" role="dialog" aria-modal="true" aria-labelledby="logoModalTitle" onclick="if(event.target===this)closeOverlay('logoModal')">
  <div class="card" style="width:100%;max-width:400px;">
    <h2 id="logoModalTitle">Pilih Tema Logo Badge</h2>
    <p class="ps" style="margin-top:0;">Ikon solid aktif dari sistem ikon resmi G7KAIH.</p>
    <div style="display:flex;gap:12px;flex-wrap:wrap;">
      @foreach ($badgeColors as $idx => $col)
        <button type="button" class="bi" style="background:{{ $col }};width:44px;height:44px;" aria-label="Pilih ikon {{ $badgeIcons[$idx] }}" onclick="closeOverlay('logoModal'); toast('Logo badge diterapkan.');"><span data-i="{{ $badgeIcons[$idx] }}"></span></button>
      @endforeach
    </div>
    <div style="display:flex;justify-content:flex-end;">
      <button type="button" class="btn o" onclick="closeOverlay('logoModal')">Tutup</button>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  @if (session('ok')) toast(@json(session('ok'))); @endif
  function openEditBadge(id, nama, desc, syarat, trigger) {
    document.getElementById('editBadgeForm').action = '/badge/' + id;
    document.getElementById('eb_nama').value = nama;
    document.getElementById('eb_desc').value = desc;
    document.getElementById('eb_syarat').value = syarat;
    openOverlay('editBadgeModal', trigger);
  }
</script>
@endpush
