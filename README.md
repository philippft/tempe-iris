<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Panduan Instalasi Project

Ikuti langkah-langkah di bawah ini untuk menjalankan project di komputer lokal Anda.

## Prasyarat
Sebelum memulai, pastikan perangkat Anda sudah menginstal:
*   **PHP 8.4**
*   **Composer**
*   **Node.js & NPM**
*   **Laragon**

---

## Langkah-Langkah Instalasi

Silakan buka terminal atau Git Bash, lalu jalankan perintah berikut secara berurutan:

### 1. Clone Repository
Unduh source code project dari GitHub ke komputer lokal Anda:
```bash
git clone [https://github.com/philippft/tempe-iris.git](https://github.com/philippft/tempe-iris.git)
cd tempe-iris
2. Install Dependencies
Install semua package PHP dan JavaScript yang dibutuhkan:

Bash
composer i
npm i
3. Setup Environment File
Salin file konfigurasi .env.example menjadi .env:

Bash
cp .env.example .env
4. Konfigurasi Database
A. Nyalakan Laragon, lalu klik Start All (pastikan Apache dan MySQL jalan).

B. Buka database manager (HeidiSQL/phpMyAdmin) dan buat database baru dengan nama tempe_iris.

C. Buka file .env pakai text editor, lalu sesuaikan konfigurasi database pada baris 23 sampai 28:

Cuplikan kode
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tempe_iris
DB_USERNAME=root
DB_PASSWORD=
5. Generate Application Key
A. Pastikan Anda masih berada di dalam folder project melalui terminal atau Git Bash.

B. Jalankan perintah berikut untuk membuat key pengaman aplikasi di file .env:

Bash
php artisan key:generate
6. Migrasi Database
A. Pastikan database tempe_iris sudah dibuat di Laragon sebelum menjalankan langkah ini.

B. Jalankan perintah migrasi berikut untuk membuat tabel-tabel ke dalam database:

Bash
php artisan migrate
(Catatan: Jika ada data bawaan awal/seeder, gunakan perintah php artisan migrate --seed)

Menjalankan Aplikasi
Setelah semua langkah instalasi di atas selesai, Anda bisa menjalankan aplikasi dengan membuka dua terminal terpisah:

Terminal 1 (Server Laravel):

Bash
php artisan serve

    Aplikasi bisa diakses di `http://127.0.0.1:8000` atau via domain Laragon (misal: `http://tempe-iris.test`).

*   **Terminal 2 (Compiler Asset):**
    ```bash
    npm run dev
    ```