@extends('layout.teacher')
@section('title', 'Verifikasi Laporan Siswa')

@section('content')
<section class="view">
  <div class="top">
    <div>
      <h1>Verifikasi Laporan Siswa</h1>
      <p class="sub">Tinjau detail kebiasaan dan foto bukti sebelum menyetujui atau menolak laporan.</p>
    </div>
  </div>

  <div class="card sh">
    <form method="GET" action="{{ route('teacher.verifikasi') }}" class="g3">
      <div class="fld">
        <label for="v_kelas">Kelas</label>
        <div class="ctl">
          <select id="v_kelas" name="id_kelas" onchange="this.form.submit()">
            <option value="">Semua Kelas</option>
            @foreach ($kelasList as $k)
              <option value="{{ $k->id_kelas }}" @selected((string) $idKelas === (string) $k->id_kelas)>{{ $k->nama_kelas }}</option>
            @endforeach
          </select>
          <span data-i="chevron-down"></span>
        </div>
      </div>
      <div class="fld">
        <label for="v_tanggal">Tanggal</label>
        <div class="ctl">
          <input id="v_tanggal" type="date" name="tanggal" value="{{ $tanggal ?? '' }}" onchange="this.form.submit()">
        </div>
      </div>
      <div class="fld">
        <label for="v_search">Cari Siswa</label>
        <div class="ctl">
          <input id="v_search" type="search" name="q" value="{{ $search }}" placeholder="Cari nama siswa atau NIS...">
          <span data-i="search"></span>
        </div>
      </div>
    </form>

    <div class="tinted-list">
      @forelse ($reports as $lap)
        @php
          $lbl = $lap->statusLabel();
          $tone = $lbl === 'Disetujui' ? 'ok' : ($lbl === 'Ditolak' ? 'bad' : 'wait');
          $nama = $lap->siswa->nama_siswa ?? '-';
          $inisial = collect(preg_split('/\s+/', trim($nama)))->take(2)->map(fn($w)=>mb_strtoupper(mb_substr($w,0,1)))->join('');
        @endphp
        <div class="tinted-row tinted-row--{{ $tone }}">
          <div class="tinted-row__id">
            <span class="av" aria-hidden="true">{{ $inisial }}</span>
            <div>
              <div class="tinted-row__name">{{ $nama }}</div>
              <div class="tinted-row__sub">{{ $lap->tanggal->translatedFormat('d M Y') }} &bull; {{ $lap->siswa->kelas->nama_kelas ?? '-' }}</div>
            </div>
          </div>

          <a href="{{ route('teacher.detail-laporan', $lap) }}" style="color:var(--pri);font-weight:600;font-size:13px;min-height:44px;display:inline-flex;align-items:center;gap:6px;">
            <span data-i="camera"></span>Lihat foto bukti
          </a>

          <span class="pill pill--{{ $tone }}">{{ $lbl }}</span>

          <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
            @if ($lbl === 'Menunggu')
              <form method="POST" action="{{ route('teacher.verify', $lap) }}">
                @csrf
                <input type="hidden" name="keputusan" value="setujui">
                <button type="submit" class="btn ok s"><span data-i="circle-check"></span>Setujui</button>
              </form>
              <button type="button" class="btn bad s" onclick="openRejectModal('{{ route('teacher.verify', $lap) }}', @js($nama), this)">
                <span data-i="circle-x"></span>Tolak
              </button>
            @endif
            <a class="btn o s" href="{{ route('teacher.detail-laporan', $lap) }}">Detail</a>
          </div>
        </div>
      @empty
        <div style="text-align:center;color:var(--mut);padding:28px;">Tidak ada laporan yang cocok dengan filter.</div>
      @endforelse
    </div>

    <div class="row" style="justify-content:space-between;flex-wrap:wrap;">
      <small style="color:var(--mut)">Menampilkan {{ $reports->firstItem() ?? 0 }}-{{ $reports->lastItem() ?? 0 }} dari {{ $reports->total() }} laporan</small>
      {{ $reports->links() }}
    </div>
  </div>
</section>

<div id="rejectModal" class="modal-backdrop" role="dialog" aria-modal="true" aria-labelledby="rejectTitle" onclick="if(event.target===this)closeOverlay('rejectModal')">
  <div class="card" style="width:100%;max-width:460px;">
    <h2 id="rejectTitle">Alasan Penolakan Laporan</h2>
    <p class="ps" id="rejectSubtitle">Berikan catatan perbaikan untuk siswa.</p>
    <form id="rejectForm" method="POST" style="display:flex;flex-direction:column;gap:14px;">
      @csrf
      <input type="hidden" name="keputusan" value="tolak">
      <div class="fld">
        <label for="rejectCatatan">Catatan Guru Wali</label>
        <div class="ctl">
          <textarea id="rejectCatatan" name="catatan" required placeholder="Contoh: Waktu bangun melewati batas 06.00 atau foto bukti kurang jelas..."></textarea>
        </div>
      </div>
      <div style="display:flex;justify-content:flex-end;gap:10px;flex-wrap:wrap;">
        <button type="button" class="btn o" onclick="closeOverlay('rejectModal')">Batal</button>
        <button type="submit" class="btn bad">Kirim Penolakan</button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
  function openRejectModal(actionUrl, studentName, trigger) {
    document.getElementById('rejectForm').action = actionUrl;
    document.getElementById('rejectSubtitle').textContent = 'Masukkan alasan penolakan untuk laporan ' + studentName + '.';
    document.getElementById('rejectCatatan').value = '';
    openOverlay('rejectModal', trigger);
  }
  @if (session('ok')) toast(@json(session('ok'))); @endif
</script>
@endpush
