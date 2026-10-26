@extends('layout.l_landing')

@section('content')
<main>
      <!-- ============ HERO ============ -->
      <section class="hero" id="tentang" aria-labelledby="hero-title">
        <img class="hero__img" src="landing/assets/hero.jpg" width="1200" height="896"
             alt="Dua siswa tersenyum membawa tas di depan gedung SMPN 21 Sinjai">
        <div class="hero__content">
          <p class="hero__eyebrow">Gerakan 7 Kebiasaan Anak Indonesia Hebat</p>
          <h1 class="hero__title" id="hero-title">Bersama Wujudkan Generasi Hebat</h1>
          <p class="hero__text">Sistem digital pelaporan Gerakan 7 Kebiasaan Anak Indonesia Hebat di SMPN 21 Sinjai.</p>
          <a class="btn btn--primary" href="#login">Mulai Bergabung</a>
        </div>
      </section>

      <!-- ============ 7 KEBIASAAN ============ -->
      <section class="habits" aria-labelledby="habits-title">
        <h2 class="habits__title" id="habits-title">Kebiasaan baik, masa depan hebat.</h2>
        <p class="habits__text">Tujuh langkah sederhana untuk tumbuh menjadi pribadi yang sehat, cerdas, dan peduli.</p>
        <ul class="habits__list">
          <li class="pill" style="--w:127px"><svg class="icon icon--sm" aria-hidden="true"><use href="#icon-sunrise"/></svg>Bangun Pagi</li>
          <li class="pill" style="--w:114px"><svg class="icon icon--sm" aria-hidden="true"><use href="#icon-heart"/></svg>Beribadah</li>
          <li class="pill" style="--w:125px"><svg class="icon icon--sm" aria-hidden="true"><use href="#icon-bike"/></svg>Berolahraga</li>
          <li class="pill" style="--w:130px"><svg class="icon icon--sm" aria-hidden="true"><use href="#icon-apple"/></svg>Makan Sehat</li>
          <li class="pill" style="--w:136px"><svg class="icon icon--sm" aria-hidden="true"><use href="#icon-book"/></svg>Gemar Belajar</li>
          <li class="pill" style="--w:142px"><svg class="icon icon--sm" aria-hidden="true"><use href="#icon-people"/></svg>Bermasyarakat</li>
          <li class="pill" style="--w:123px"><svg class="icon icon--sm" aria-hidden="true"><use href="#icon-moon"/></svg>Tidur Cepat</li>
        </ul>
      </section>

      <!-- ============ FITUR ============ -->
      <section class="features" id="fitur" aria-label="Keunggulan">
        <ul class="features__list">
          <li class="feature">
            <span class="feature__icon"><svg class="icon" aria-hidden="true"><use href="#icon-users"/></svg></span>
            <div class="feature__body">
              <h2 class="feature__title">7 Kebiasaan Hebat</h2>
              <p class="feature__text">Bangun karakter melalui kebiasaan baik setiap hari.</p>
            </div>
          </li>
          <li class="feature">
            <span class="feature__icon"><svg class="icon" aria-hidden="true"><use href="#icon-clipboard"/></svg></span>
            <div class="feature__body">
              <h2 class="feature__title">Pelaporan Mudah</h2>
              <p class="feature__text">Catat aktivitas harian dari desktop atau ponsel.</p>
            </div>
          </li>
          <li class="feature">
            <span class="feature__icon"><svg class="icon" aria-hidden="true"><use href="#icon-award"/></svg></span>
            <div class="feature__body">
              <h2 class="feature__title">Badge Pencapaian</h2>
              <p class="feature__text">Apresiasi nyata untuk kebiasaan yang konsisten.</p>
            </div>
          </li>
          <li class="feature">
            <span class="feature__icon"><svg class="icon" aria-hidden="true"><use href="#icon-school"/></svg></span>
            <div class="feature__body">
              <h2 class="feature__title">Untuk Masa Depan</h2>
              <p class="feature__text">Kolaborasi sekolah untuk generasi Indonesia hebat.</p>
            </div>
          </li>
        </ul>
      </section>
    </main>
@endsection