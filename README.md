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
