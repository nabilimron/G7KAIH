# Sistem Pelaporan G7KAIH — SMPN 21 Sinjai

Aplikasi web **Gerakan 7 Kebiasaan Anak Indonesia Hebat (G7KAIH)** berbasis Laravel 13 & MySQL (`db_g7kaih`) dengan desain responsif (Desktop, Tablet, Mobile) dan mode Terang/Gelap.

### Fitur Utama per Peran
- **Publik (`/home`, `/login`, `/lupa-sandi`):** Landing page 7 kebiasaan, login menggunakan username atau email sekolah.
- **Siswa (`/student`):** Progres laporan mingguan, pengisian 7 kebiasaan harian + catatan opsional & simpan sementara, riwayat laporan + detail catatan guru wali, lencana pencapaian (6 badge), serta profil & ubah sandi.
- **Guru Wali (`/teacher`):** Dashboard perwalian, verifikasi laporan (setujui/tolak/catatan), rekapitulasi per kelas & grafik perkembangan (4 periode), ekspor CSV/Excel & PDF, detail siswa, dan modal profil guru wali.
- **Admin (`/admin`):** Dashboard tren pelaporan & status verifikasi, kelola akun & reset password, atur perwalian per kelas & siswa, kelola badge pencapaian & logo badge, pemantauan seluruh laporan, serta pengaturan tahun ajaran & keamanan akun.

---

## 1. Pemasangan Cepat dengan Docker (Direkomendasikan)

### Prasyarat
- **Docker** & **Docker Compose v2** (`docker compose version`)
- Pastikan port `8000` (web) dan `3307` (MySQL container) tidak sedang dipakai layanan lain.

### Langkah Pemasangan
1. Ekstrak arsip `G7KAIH-docker.zip` lalu masuk ke direktori hasil ekstrak:
   ```bash
   unzip G7KAIH-docker.zip -d G7KAIH
   cd G7KAIH
   ```
2. Build image dan jalankan container aplikasi + MySQL:
   ```bash
   docker compose up -d --build
   ```
   > Saat pertama kali menyala, `docker/entrypoint.sh` otomatis menyalin `.env.docker` ke `.env`, menunggu MySQL siap, menjalankan `php artisan migrate --force`, dan mengisi data awal (`php artisan db:seed --force`) bila tabel `users` masih kosong.

3. Pantau log startup hingga Nginx & PHP-FPM berjalan:
   ```bash
   docker compose logs -f app
   ```
4. Buka di browser:
   - **Landing Page:** `http://localhost:8000`
   - **Halaman Login:** `http://localhost:8000/login`

### Perintah Docker yang Berguna
- Hentikan container:
  ```bash
  docker compose down
  ```
- Reset database ke kondisi awal (kosongkan riwayat laporan & isi ulang akun dummy):
  ```bash
  docker compose exec app php artisan migrate:fresh --seed --force
  ```
- Jalankan pengujian otomatis (Pest):
  ```bash
  docker compose exec app vendor/bin/pest
  ```
- Akses MySQL container dari host:
  - Host: `127.0.0.1`, Port: `3307`, Database: `db_g7kaih`, User: `g7kaih`, Password: `g7kaih_secret`

---

## 2. Pemasangan Manual (Tanpa Docker)

### Prasyarat
- PHP `>= 8.3` dengan ekstensi `pdo_mysql`, `mbstring`, `gd`, `zip`, `intl`
- Composer, Node.js `>= 20` & npm
- MySQL / MariaDB dengan database bernama `db_g7kaih`

### Langkah Pemasangan
```bash
composer install
cp .env.example .env
php artisan key:generate
```
Sesuaikan koneksi database di `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_g7kaih
DB_USERNAME=root
DB_PASSWORD=
```
Lalu jalankan migrasi, seeder (atau impor `database/db_g7kaih.sql`), build aset, dan server lokal:
```bash
php artisan migrate --seed
npm install
npm run build
php artisan serve --host=0.0.0.0 --port=8000
```

---

## 3. Akun Dummy Pengujian

Seeder awal menyediakan 4 akun (riwayat laporan masih kosong agar siap diuji dari awal):

| Peran | Username | Email Sekolah | Kata Sandi |
|---|---|---|---|
| **Admin 1** | `admin1` | `admin1@smpn21sinjai.sch.id` | `password` / `Password123` |
| **Admin 2** | `admin2` | `admin2@smpn21sinjai.sch.id` | `password` / `Password123` |
| **Guru Wali** | `guru1` | `guru1@smpn21sinjai.sch.id` | `password` / `Password123` |
| **Siswa** | `siswa1` | `siswa1@smpn21sinjai.sch.id` | `password` / `Password123` |
