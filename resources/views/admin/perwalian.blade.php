@extends('layout.admin')
@section('title', 'Atur Perwalian')

@section('content')
<section class="view on">
 <div class="top">
  <div><h1>Atur Perwalian</h1><p class="sub">Tetapkan guru wali dan kelola siswa pada setiap kelas.</p></div>
 </div>

 <div class="card sh">
  <h2>Pengaturan Kelas &amp; Guru Wali</h2>

  <form method="GET" action="{{ route('admin.perwalian') }}" class="row" style="gap:16px;">
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

  {{-- Tabel Utama Kelas & Guru Wali (Figma 434:2733) --}}
  <div class="tw">
   <table>
    <thead>
     <tr><th>Kelas</th><th>Guru Wali</th><th>Jumlah Siswa</th><th style="width:110px">Aksi</th></tr>
    </thead>
    <tbody>
     @forelse ($kelasRows as $row)
      <tr>
       <td><strong>{{ $row['kelas']->nama_kelas }}</strong></td>
       <td>{{ $row['guru']->nama_guru ?? 'Belum ditentukan' }}</td>
       <td>{{ $row['jumlah'] }}</td>
       <td>
        <button type="button" class="btn s" onclick="openKelolaKelas({{ $row['kelas']->id_kelas }})">Kelola</button>
       </td>
      </tr>
     @empty
      <tr><td colspan="4" style="text-align:center;color:var(--mut);padding:24px;">Belum ada data kelas yang cocok.</td></tr>
     @endforelse
    </tbody>
   </table>
  </div>

  <div style="display:flex;justify-content:flex-end;">
   <button type="button" class="btn" onclick="toast('Perwalian kelas tersinkron ke db_g7kaih.')"><span data-i="save"></span>Simpan Perubahan</button>
  </div>
 </div>

 <div class="info">
  <span data-i="info"></span>
  <div>
   <strong>Satu kelas, satu guru wali</strong>
   <p>Guru wali dapat memantau dan memverifikasi laporan siswa yang ada di kelas perwaliannya.</p>
  </div>
 </div>

 {{-- Modal Kelola Perwalian per Kelas (menampilkan seluruh siswa di kelas tsb & ubah guru wali) --}}
 @foreach ($kelasRows as $row)
  <div id="modalKelas_{{ $row['kelas']->id_kelas }}" class="kelola-modal" style="display:none;position:fixed;inset:0;z-index:70;background:rgba(16,46,84,.45);align-items:center;justify-content:center;padding:16px;">
   <div class="card" style="width:100%;max-width:560px;max-height:85vh;overflow-y:auto;">
    <div class="row" style="align-items:center;">
     <h2 style="flex:1;">Kelola Perwalian Kelas {{ $row['kelas']->nama_kelas }}</h2>
     <button type="button" class="btn o s" onclick="document.getElementById('modalKelas_{{ $row['kelas']->id_kelas }}').style.display='none'">Tutup</button>
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
           <select name="id_guru" style="height:32px;padding:0 8px;border-radius:6px;border:1px solid var(--line);background:#fff;">
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
 paint();
 @if (session('ok')) toast(@json(session('ok'))); @endif
 function openKelolaKelas(id) {
  var m = document.getElementById('modalKelas_' + id);
  if (m) m.style.display = 'flex';
 }
</script>
@endpush
