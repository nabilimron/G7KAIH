@extends('layout.student')
@section('title', 'Mengisi Laporan G7KAIH')

@section('content')
<h1 class="page-title">Mengisi Laporan G7KAIH</h1>

<div class="grid-laporan">
  <section class="card">
    @if ($existing)
      <div class="alert alert--amber">
        Laporan untuk tanggal <strong>{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</strong> sudah tersimpan.
        <a style="color:var(--blue);font-weight:600;margin-left:auto;" href="{{ route('student.riwayat.detail', $existing) }}">Lihat detail &rarr;</a>
      </div>
    @endif

    <form id="laporanForm" method="POST" action="{{ route('student.laporan.store') }}">
      @csrf
      @php $valTanggal = old('tanggal', request('tanggal', '')); @endphp
      <div class="field" style="margin-bottom:12px;">
        <label class="field__label" for="tanggal">Tanggal</label>
        <div class="input-wrap input-picker {{ $valTanggal === '' ? 'is-empty' : '' }}">
          <input id="tanggal" type="date" name="tanggal"
                 value="{{ $valTanggal }}"
                 min="{{ now()->subDays(7)->toDateString() }}"
                 max="{{ now()->toDateString() }}" required>
          <span class="input-picker__ph">Pilih tanggal</span>
          <span class="input-picker__ico" aria-hidden="true">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><path d="M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01"/></svg>
          </span>
        </div>
        @error('tanggal') <span class="field__err">{{ $message }}</span> @enderror
      </div>

      <div class="alert alert--amber" style="margin-bottom:20px;">
        <svg viewBox="0 0 24 24" width="18" height="18" fill="#d97706" stroke="#fff" stroke-width="2" style="flex:none;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <span>Kamu dapat memilih untuk mengisi tanggal sebelumnya jika terdapat beberapa kendala.</span>
      </div>

      @foreach ($kebiasaan as $idx => $keb)
        @if ($idx === 0)
          @php $valBangun = old('kebiasaan.' . $keb->id_kebiasaan . '.waktu', ''); @endphp
          {{-- Bangun Pagi: Input Waktu Bangun (Figma 543:7234) --}}
          <div class="field">
            <label class="habit-check-row__title" for="keb_{{ $keb->id_kebiasaan }}_waktu">
              <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#1f6fd6" stroke-width="2"><path d="M12 2v8"/><path d="m4.93 10.93 1.41 1.41"/><path d="M2 18h2"/><path d="M20 18h2"/><path d="m19.07 10.93-1.41 1.41"/><path d="M22 22H2"/><path d="m8 6 4-4 4 4"/><path d="M16 18a4 4 0 0 0-8 0"/></svg>
              <span>{{ $keb->nama_kebiasaan }}</span>
            </label>
            <input type="hidden" name="kebiasaan[{{ $keb->id_kebiasaan }}][status]" value="1">
            <div class="input-wrap input-picker {{ $valBangun === '' ? 'is-empty' : '' }}">
              <input id="keb_{{ $keb->id_kebiasaan }}_waktu" type="time"
                     name="kebiasaan[{{ $keb->id_kebiasaan }}][waktu]"
                     value="{{ $valBangun }}" required>
              <span class="input-picker__ph">Waktu Bangun</span>
              <span class="input-picker__ico" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
              </span>
            </div>
            <span class="field__hint">Waktu bangun yang baik adalah 04.00 &ndash; 06.00</span>
          </div>
        @elseif ($idx === $kebiasaan->count() - 1)
          @php $valTidur = old('kebiasaan.' . $keb->id_kebiasaan . '.waktu', ''); @endphp
          {{-- Tidur Cepat: Input Waktu Tidur (Figma 543:7234) --}}
          <div class="field" style="margin-top:8px;">
            <label class="habit-check-row__title" for="keb_{{ $keb->id_kebiasaan }}_waktu">
              <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#1f6fd6" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
              <span>{{ $keb->nama_kebiasaan }}</span>
            </label>
            <input type="hidden" name="kebiasaan[{{ $keb->id_kebiasaan }}][status]" value="1">
            <div class="input-wrap input-picker {{ $valTidur === '' ? 'is-empty' : '' }}">
              <input id="keb_{{ $keb->id_kebiasaan }}_waktu" type="time"
                     name="kebiasaan[{{ $keb->id_kebiasaan }}][waktu]"
                     value="{{ $valTidur }}" required>
              <span class="input-picker__ph">Waktu Tidur</span>
              <span class="input-picker__ico" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
              </span>
            </div>
            <span class="field__hint">Waktu tidur yang baik adalah 20.00 &ndash; 22.00</span>
          </div>
        @else
          {{-- Kebiasaan 2..6: Baris checklist Terlaksana di kanan + kolom catatan opsional --}}
          <div class="habit-block" style="padding:6px 0;">
            <div class="habit-check-row">
              <span class="habit-check-row__title">
                @if ($idx === 1)
                  <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#1f6fd6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                @elseif ($idx === 2)
                  <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#1f6fd6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18.5" cy="17.5" r="3.5"/><circle cx="5.5" cy="17.5" r="3.5"/><circle cx="15" cy="5" r="1"/><path d="M12 17.5V14l-3-3 4-3 2 3h2"/></svg>
                @elseif ($idx === 3)
                  <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#1f6fd6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/><path d="M7 2v20"/><path d="M21 15V2v0a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Zm0 0v7"/></svg>
                @elseif ($idx === 4)
                  <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#1f6fd6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                @else
                  <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#1f6fd6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                @endif
                <span>{{ $keb->nama_kebiasaan }}</span>
              </span>
              <label class="habit-check-pill">
                <input type="checkbox"
                       class="habit-cb"
                       data-note-id="note_{{ $keb->id_kebiasaan }}"
                       id="keb_{{ $keb->id_kebiasaan }}_status"
                       name="kebiasaan[{{ $keb->id_kebiasaan }}][status]"
                       value="1"
                       @checked(old('kebiasaan.' . $keb->id_kebiasaan . '.status'))>
                <span>Terlaksana</span>
              </label>
            </div>
            <div id="note_{{ $keb->id_kebiasaan }}" class="habit-note" style="display:none;padding:4px 0 8px 28px;">
              <label for="keb_{{ $keb->id_kebiasaan }}_ket" style="display:block;font-size:12px;color:var(--muted);margin-bottom:4px;">Catatan</label>
              <div class="input-wrap">
                <input id="keb_{{ $keb->id_kebiasaan }}_ket" type="text"
                       name="kebiasaan[{{ $keb->id_kebiasaan }}][keterangan]"
                       value="{{ old('kebiasaan.' . $keb->id_kebiasaan . '.keterangan', '') }}"
                       placeholder="Tambahkan alasan atau catatan jika diperlukan...">
              </div>
            </div>
          </div>
        @endif
      @endforeach

      <div id="draftNotice" class="alert alert--ok" style="display:none;margin-top:12px;">
        Draf laporan berhasil disimpan sementara di perangkat ini.
      </div>

      <div class="form-actions-2" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:14px;margin-top:20px;">
        <button type="button" class="btn btn--primary btn--lg" onclick="var f=document.getElementById('laporanForm'); if(f.reportValidity()){ document.getElementById('confirmSaveModal').classList.add('is-open'); }">Simpan Permanen</button>
        <button type="button" class="btn btn--secondary btn--lg" id="saveDraftBtn">Simpan Sementara</button>
      </div>
    </form>
  </section>

  <aside class="list-stack" style="gap:24px;">
    <section class="card">
      <h2 class="card__title" style="margin-bottom:14px;">Tips Laporan</h2>
      <div class="list-stack" style="gap:12px;font-size:12px;color:var(--muted);line-height:1.6;">
        <div style="display:flex;gap:10px;align-items:flex-start;">
          <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#07805d" stroke-width="2" style="flex:none;margin-top:1px;"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
          <span>Isi sesuai aktivitas yang kamu lakukan.</span>
        </div>
        <div style="display:flex;gap:10px;align-items:flex-start;">
          <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#07805d" stroke-width="2" style="flex:none;margin-top:1px;"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
          <span>Pastikan tanggal dan waktu sudah benar.</span>
        </div>
      </div>
    </section>

    <section class="card">
      <h2 class="card__title" style="margin-bottom:12px;">Tips Catatan</h2>
      <p style="font-size:12px;color:var(--muted);line-height:1.6;margin:0 0 12px;">
        Jika ada kegiatan yang belum terlaksanakan, kamu bisa menambahkan catatan di kolom yang tersedia.
      </p>
      <p style="font-size:12px;color:var(--muted);line-height:1.6;margin:0;">
        Jika kamu perlu mengubah laporan, simpan sementara dulu agar data tidak hilang.
      </p>
    </section>
  </aside>
</div>

<div class="modal-backdrop" id="confirmSaveModal" role="dialog" aria-modal="true">
  <div class="modal-box">
    <h3 class="modal-box__title">Konfirmasi Simpan Permanen</h3>
    <p class="modal-box__text">Pastikan seluruh 7 kebiasaan sudah diisi dengan jujur. Laporan yang disimpan akan dikirim ke guru wali untuk diverifikasi.</p>
    <div class="modal-box__actions">
      <button type="button" class="btn btn--secondary" onclick="document.getElementById('confirmSaveModal').classList.remove('is-open')">Batal</button>
      <button type="button" class="btn btn--primary" onclick="localStorage.removeItem('g7kaih-draft-' + document.getElementById('tanggal').value); document.getElementById('laporanForm').submit()">Ya, Simpan Permanen</button>
    </div>
  </div>
</div>

@push('scripts')
<script>
(function () {
  var dateEl = document.getElementById('tanggal');
  var draftBtn = document.getElementById('saveDraftBtn');
  var notice = document.getElementById('draftNotice');

  function syncPickerState(el) {
    var wrap = el.closest('.input-picker');
    if (wrap) wrap.classList.toggle('is-empty', !el.value);
  }
  document.querySelectorAll('.input-picker input').forEach(function (el) {
    syncPickerState(el);
    el.addEventListener('input', function () { syncPickerState(el); });
    el.addEventListener('change', function () { syncPickerState(el); });
  });

  document.querySelectorAll('.habit-cb').forEach(function (cb) {
    cb.addEventListener('change', function () {
      var noteBox = document.getElementById(cb.dataset.noteId);
      if (noteBox) noteBox.style.display = cb.checked ? 'none' : 'block';
    });
  });

  function draftKey() { return 'g7kaih-draft-' + (dateEl ? dateEl.value : 'today'); }

  function restoreDraft() {
    try {
      var raw = localStorage.getItem(draftKey());
      if (!raw) return;
      var data = JSON.parse(raw);
      Object.keys(data).forEach(function (id) {
        var el = document.getElementById(id);
        if (!el) return;
        if (el.type === 'checkbox') el.checked = !!data[id];
        else { el.value = data[id]; syncPickerState(el); }
      });
    } catch (e) {}
  }

  restoreDraft();
  dateEl?.addEventListener('change', restoreDraft);

  draftBtn?.addEventListener('click', function () {
    var payload = {};
    document.querySelectorAll('#laporanForm input[id^="keb_"]').forEach(function (el) {
      payload[el.id] = el.type === 'checkbox' ? el.checked : el.value;
    });
    localStorage.setItem(draftKey(), JSON.stringify(payload));
    if (notice) {
      notice.style.display = 'flex';
      setTimeout(function () { notice.style.display = 'none'; }, 3500);
    }
  });
})();
</script>
@endpush
@endsection
