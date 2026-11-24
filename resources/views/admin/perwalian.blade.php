@extends('layout.admin')
@section('title', 'Atur Perwalian')

@section('content')
<section class="view">
  <div class="top">
    <div>
      <h1>Atur Perwalian</h1>
      <p class="sub">Tetapkan guru wali dan kelola siswa pada setiap kelas.</p>
    </div>
  </div>

  <div class="info">
    <span data-i="info"></span>
    <div>
      <strong>Satu kelas, satu guru wali</strong>
      <p>Guru wali dapat memantau dan memverifikasi laporan siswa yang ada di kelas perwaliannya.</p>
    </div>
  </div>

  <div class="card sh">
    <h2>Pengaturan Kelas &amp; Guru Wali</h2>

    <form method="GET" action="{{ route('admin.perwalian') }}" class="row" style="gap:16px;flex-wrap:wrap;">
      <div class="fld" style="min-width:190px;">
        <label for="f_kelas">Kelas</label>
        <div class="ctl">
          <select id="f_kelas" name="id_kelas" onchange="this.form.submit()">
            <option value="">Semua Kelas</option>
            @foreach ($kelasList as $k)
              <option value="{{ $k->id_kelas }}" @selected((string) $idKelas === (string) $k->id_kelas)>{{ $k->nama_kelas }}</option>
            @endforeach
          </select>
          <span data-i="chevron-down"></span>
        </div>
      </div>
      <div class="fld" style="min-width:210px;">
        <label for="f_guru">Guru Wali</label>
        <div class="ctl">
          <select id="f_guru" name="id_guru" onchange="this.form.submit()">
            <option value="">Semua Guru Wali</option>
            @foreach ($guruList as $g)
              <option value="{{ $g->id_guru }}" @selected((string) $idGuru === (string) $g->id_guru)>{{ $g->nama_guru }}</option>
            @endforeach
          </select>
          <span data-i="chevron-down"></span>
        </div>
      </div>
    </form>

    <div class="tinted-list">
      @forelse ($kelasRows as $row)
        <div class="tinted-row tinted-row--soft">
          <div>
            <div class="tinted-row__name">Kelas {{ $row['kelas']->nama_kelas }} ({{ $row['jumlah'] }} Siswa)</div>
            <div class="tinted-row__sub">Wali: {{ $row['guru']->nama_guru ?? 'Belum ditentukan' }}</div>
          </div>
          <button type="button" class="btn s" onclick="openOverlay('modalKelas_{{ $row['kelas']->id_kelas }}', this)">Kelola</button>
        </div>
      @empty
        <div style="text-align:center;color:var(--mut);padding:24px;">Belum ada data kelas yang cocok.</div>
      @endforelse
    </div>

    <div style="display:flex;justify-content:flex-end;">
      <button type="button" class="btn" onclick="toast('Perwalian kelas tersinkron ke db_g7kaih.')"><span data-i="save"></span>Simpan Perubahan</button>
    </div>
  </div>

  @foreach ($kelasRows as $row)
    <div id="modalKelas_{{ $row['kelas']->id_kelas }}" class="modal-backdrop" role="dialog" aria-modal="true" aria-labelledby="mkTitle_{{ $row['kelas']->id_kelas }}" onclick="if(event.target===this)closeOverlay('modalKelas_{{ $row['kelas']->id_kelas }}')">
      <div class="card" style="width:100%;max-width:560px;max-height:85vh;overflow-y:auto;">
        <div class="row" style="align-items:center;">
          <h2 id="mkTitle_{{ $row['kelas']->id_kelas }}" style="flex:1;">Kelola Perwalian Kelas {{ $row['kelas']->nama_kelas }}</h2>
          <button type="button" class="btn o s" onclick="closeOverlay('modalKelas_{{ $row['kelas']->id_kelas }}')">Tutup</button>
        </div>

        <form method="POST" action="{{ route('admin.perwalian.kelas', $row['kelas']) }}" style="display:flex;gap:10px;align-items:flex-end;flex-wrap:wrap;">
          @csrf @method('PUT')
          <div class="fld" style="min-width:200px;">
            <label for="kg_{{ $row['kelas']->id_kelas }}">Tetapkan Guru Wali Kelas</label>
            <div class="ctl">
              <select id="kg_{{ $row['kelas']->id_kelas }}" name="id_guru">
                @foreach ($guruList as $g)
                  <option value="{{ $g->id_guru }}" @selected(($row['guru']->id_guru ?? null) === $g->id_guru)>{{ $g->nama_guru }}</option>
                @endforeach
              </select>
              <span data-i="chevron-down"></span>
            </div>
          </div>
          <button type="submit" class="btn sm"><span data-i="save"></span>Simpan Kelas</button>
        </form>

        <div class="tw">
          <table style="min-width:100%;">
            <thead><tr><th>NISN</th><th>Nama Siswa</th><th>Guru Wali</th><th>Aksi</th></tr></thead>
            <tbody>
              @forelse ($row['siswa'] as $s)
                <tr>
                  <td>{{ $s->nisn }}</td>
                  <td><strong>{{ $s->nama_siswa }}</strong></td>
                  <td>
                    <form method="POST" action="{{ route('admin.perwalian.update', $s) }}" id="pw_{{ $s->id_siswa }}">
                      @csrf @method('PUT')
                      <input type="hidden" name="id_kelas" value="{{ $s->id_kelas }}">
                      <select name="id_guru" style="height:44px;padding:0 8px;border-radius:10px;border:1px solid var(--line);background:var(--card);">
                        @foreach ($guruList as $g)
                          <option value="{{ $g->id_guru }}" @selected($s->id_guru === $g->id_guru)>{{ $g->nama_guru }}</option>
                        @endforeach
                      </select>
                    </form>
                  </td>
                  <td><button type="submit" form="pw_{{ $s->id_siswa }}" class="btn s">Simpan</button></td>
                </tr>
              @empty
                <tr><td colspan="4" style="text-align:center;color:var(--mut);padding:16px;">Belum ada siswa di kelas ini.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  @endforeach
</section>
@endsection

@push('scripts')
<script>
  @if (session('ok')) toast(@json(session('ok'))); @endif
</script>
@endpush
