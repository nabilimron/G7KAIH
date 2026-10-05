<<<<<<< HEAD
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
=======
# Sistem Laporan G7KAIH

> **G7KAIH (Gerakan 7 Kebiasaan Anak Indonesia Hebat)** adalah sebuah platform/media digital berbasis web untuk pengelolaan dan pelaporan program pembiasaan siswa yang dipantau langsung oleh guru wali di SMPN 21 Sinjai.

Sistem ini menggantikan pelaporan manual berbasis buku kertas. Dilengkapi dengan *landing page*, sistem autentikasi (login) berbasis peran, pengelolaan akun pengguna oleh admin, fitur pengisian laporan harian (termasuk input laporan mundur dan unggah foto bukti), validasi otomatis, serta *dashboard* rekapitulasi laporan yang interaktif (tabel dan grafik) berdasarkan rentang waktu harian, mingguan, bulanan, hingga semester, dengan fitur unduh rekap dalam format Excel. Sistem diakses melalui Google Chrome tanpa instalasi aplikasi dan menggunakan tema warna biru yang menyesuaikan buku laporan SMP dari pemerintah.

---

## Tim Pengembang (Kelompok 3)

- **Nurfaizah**
- **Muh. Akram Marzuki**
- **Nabil Imron**
- **Inriani**
- **Christian Gerrard M. Rantelino**

---

## Fitur Utama

Sistem ini membagi hak akses ke dalam 3 subjek utama dengan fitur masing-masing sebagai berikut:

### 1. Admin
Admin memiliki kontrol penuh terhadap manajemen data master dan pemantauan sistem secara keseluruhan.
- Menambahkan, mengubah, dan menonaktifkan akun **Guru Wali**.
- Menambahkan, mengubah, dan menonaktifkan akun **Siswa**.
- Menetapkan **Guru Wali** untuk masing-masing siswa.
- Melihat rekapitulasi laporan G7KAIH seluruh siswa.
- Filter laporan berdasarkan rentang waktu: **Harian, Mingguan, Bulanan, dan Semester**.
- Visualisasi data laporan dalam bentuk **Tabel** dan **Grafik**.

### 2. Guru Wali
Guru wali bertugas memantau dan memverifikasi perkembangan siswa yang berada di bawah perwaliannya.
- Melihat daftar siswa perwalian.
- Memantau detail laporan harian G7KAIH dari siswa perwalian.
- Memverifikasi laporan siswa berdasarkan **foto bukti** kegiatan.
- Filter laporan berdasarkan rentang waktu: **Harian, Mingguan, Bulanan, dan Semester** (6 bulan).
- Visualisasi data laporan dalam bentuk **Tabel** dan **Grafik**.
- Mengunduh rekap laporan (bulanan dan semester) dalam format **Excel (.xlsx)**.

### 3. Siswa
Siswa merupakan subjek utama yang menjalankan program dan melaporkan kebiasaannya.
- Mengisi form laporan G7KAIH secara rutin setiap hari untuk 7 kebiasaan: bangun pagi, beribadah, berolahraga, makan sehat, gemar belajar, bermasyarakat, dan tidur cepat.
- **Input laporan mundur (backdate)** dengan memilih tanggal dan jam kegiatan, untuk mengatasi kendala jaringan.
- **Unggah foto bukti** kegiatan (misalnya ibadah dan makan sehat) sebagai dasar verifikasi guru wali. Foto dikompres otomatis sebelum diunggah.
- Melihat riwayat laporan G7KAIH milik sendiri.
- Filter riwayat laporan berdasarkan rentang waktu: **Harian, Mingguan, Bulanan, dan Semester**.
- Memantau perkembangan (progres) laporan dalam bentuk **Tabel** dan **Grafik**.

---

## Aturan Sistem

- **Validasi otomatis bangun pagi:** jam bangun pukul 04.00–06.00 dinilai sah, sedangkan pukul 07.00 atau lebih dinilai tidak bangun pagi.
- **Hak akses berdasarkan peran:** siswa hanya melihat laporannya sendiri, guru wali hanya melihat siswa perwaliannya, dan akun hanya dibuat oleh admin.
- **Ringan dan berbasis web:** dapat diakses melalui Google Chrome di HP tanpa instalasi aplikasi, serta tetap dapat digunakan pada jaringan lemah.

---

## Cara Menjalankan Proyek (Local Development)

1. **Clone repositori ini:**
```bash
   git clone https://github.com/username-kamu/nama-repo-g7kaih.git
   cd nama-repo-g7kaih
```

2. **Instal dependensi:**
```bash
   npm install
```

3. **Atur konfigurasi environment:**
```bash
   cp .env.example .env
```

4. **Jalankan server development:**
```bash
   npm run dev
```
>>>>>>> b878edc19a0f81d89843dbf354bd23b8202427ae
