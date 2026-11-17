@extends('layout.l_landing')

@section('content')
<main>
      <!-- ============ HERO (Figma 543:1512) ============ -->
      <section class="hero" aria-labelledby="hero-title">
        <img class="hero__img" src="{{ asset('landing/assets/hero.jpg') }}" width="1200" height="896"
             alt="Dua siswa tersenyum membawa tas di depan gedung SMPN 21 Sinjai">
        <div class="hero__content">
          <h1 class="hero__title" id="hero-title">Bersama Wujudkan Generasi Hebat</h1>
          <p class="hero__text">Sistem digital pelaporan Gerakan 7 Kebiasaan Anak Indonesia Hebat (G7KAIH) di SMPN 21 Sinjai.</p>
        </div>
      </section>

      <!-- ============ 7 KEBIASAAN (terhubung db_g7kaih.kebiasaan) ============ -->
      <section class="habits" id="tentang" aria-labelledby="habits-title">
        <h2 class="habits__title" id="habits-title">Kebiasaan Yang Baik, Masa Depan Yang Hebat.</h2>
        <p class="habits__text">Tujuh langkah sederhana untuk tumbuh menjadi pribadi yang sehat, cerdas, dan peduli.</p>
        @php
          $habitIcons = ['#icon-sunrise', '#icon-heart', '#icon-bike', '#icon-utensils', '#icon-book', '#icon-people', '#icon-moon'];
        @endphp
        <ul class="habits__list">
          @foreach ($kebiasaan as $idx => $keb)
            <li class="pill"><svg class="icon icon--sm" aria-hidden="true"><use href="{{ $habitIcons[$idx % count($habitIcons)] }}"/></svg>{{ $keb->nama_kebiasaan }}</li>
          @endforeach
        </ul>
      </section>

      <!-- ============ FITUR ============ -->
      <section class="features" id="fitur" aria-label="Keunggulan">
        <ul class="features__list">
          <li class="feature">
            <span class="feature__icon"><svg class="icon" aria-hidden="true"><use href="#icon-users"/></svg></span>
            <div class="feature__body">
              <h2 class="feature__title">7 Kebiasaan Hebat</h2>
              <p class="feature__text">Membangun karakter melalui kebiasaan yang baik setiap harinya.</p>
            </div>
          </li>
          <li class="feature">
            <span class="feature__icon"><svg class="icon" aria-hidden="true"><use href="#icon-clipboard"/></svg></span>
            <div class="feature__body">
              <h2 class="feature__title">Laporan Fleksibel</h2>
              <p class="feature__text">Mencatat aktivitas harian dari perangkat manapun.</p>
            </div>
          </li>
          <li class="feature">
            <span class="feature__icon"><svg class="icon" aria-hidden="true"><use href="#icon-award"/></svg></span>
            <div class="feature__body">
              <h2 class="feature__title">Lencana Pencapaian</h2>
              <p class="feature__text">Apresiasi nyata untuk aktivitas kamu yang konsisten di tiap waktunya.</p>
            </div>
          </li>
          <li class="feature">
            <span class="feature__icon"><svg class="icon" aria-hidden="true"><use href="#icon-school"/></svg></span>
            <div class="feature__body">
              <h2 class="feature__title">Untuk Masa Depan</h2>
              <p class="feature__text">Kolaborasi sekolah untuk menciptakan Generasi Indonesia yang Hebat.</p>
            </div>
          </li>
        </ul>
      </section>

      <!-- ============ KONTAK & INFORMASI SEKOLAH (Figma 543:1512) ============ -->
      <section class="contact-section" id="kontak" aria-labelledby="contact-title">
        <h2 class="contact-section__title" id="contact-title">Kontak &amp; Informasi Sekolah</h2>
        <div class="contact-grid">
          <div class="contact-card">
            <span class="contact-card__icon">
              <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="12" cy="10" r="2"/><path d="M8 16c0-2 8-2 8 0"/></svg>
            </span>
            <div>
              <div class="contact-card__label">Kontak Sekolah</div>
              <div class="contact-card__val">0852-5575-2831</div>
            </div>
          </div>
          <div class="contact-card">
            <span class="contact-card__icon">
              <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
            </span>
            <div>
              <div class="contact-card__label">Surel Admin Sekolah</div>
              <div class="contact-card__val">admin@smpn21sinjai.sch.id</div>
            </div>
          </div>
          <div class="contact-card">
            <span class="contact-card__icon">
              <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </span>
            <div>
              <div class="contact-card__label">Jam Layanan Sekolah</div>
              <div class="contact-card__val">(Senin &ndash; Sabtu) 08.00 &ndash; 15.00 WITA</div>
            </div>
          </div>
        </div>
      </section>
    </main>
@endsection
