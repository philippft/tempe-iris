<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Tempe Iris

**Tempe Iris** adalah aplikasi berbasis web yang dibangun menggunakan ekosistem terbaru dari Laravel framework. Project ini dirancang dengan struktur arsitektur modern yang efisien, performa optimal, serta alur kerja pengembangan yang terintegrasi penuh untuk kebutuhan manajemen data dan skalabilitas aplikasi backend.

---

## 🚀 Fitur Utama

* **Arsitektur MVC Modern:** Memanfaatkan struktur dasar Laravel untuk pemisahan logika bisnis, database, dan presentasi secara rapi.
* **Asset Bundling Cepat dengan Vite:** Kompilasi frontend secepat kilat menggunakan integrasi penuh Vite untuk manajemen CSS dan JavaScript.
* **Database Management yang Andal:** Migrasi database otomatis yang aman serta pengelolaan relasi data berbasis Eloquent ORM.
* **Pengujian Komprehensif (Testing Ready):** Terintegrasi langsung dengan **Pest PHP** untuk mendukung pengembangan berbasis *Test-Driven Development* (TDD).
* **Otomatisasi Script Pengembang:** Menyediakan perintah otomatis satu pintu (`composer run setup`) untuk mempercepat instalasi lingkungan lokal.

---

## 🛠️ Teknologi yang Digunakan

* **Framework Inti:** Laravel ^13.0
* **Bahasa Pemrograman:** PHP ^8.3
* **Asset Compiler:** Vite & NPM Engine
* **Testing Framework:** Pest PHP & Mockery
* **Database Support:** MySQL / SQLite
* **Code Style & Linting:** Laravel Pint

---

## 📌 Prasyarat Instalasi

Sebelum memulai proses instalasi di komputer lokal Anda, pastikan perangkat Anda sudah terpasang perkakas berikut:
* **PHP (Minimal versi 8.3, disarankan versi 8.4)**
* **Composer** (Manajer dependensi PHP)
* **Node.js & NPM** (Runtime JavaScript dan Manajer Package)
* **Laragon** atau Web Server Lokal sejenis (Apache/Nginx & MySQL)

---

## 💻 Langkah-Langkah Instalasi

Silakan buka terminal, Command Prompt, atau Git Bash Anda, lalu jalankan perintah berikut secara berurutan:

### 1. Clone Repository
Unduh *source code* project dari GitHub ke komputer lokal Anda:
```bash
git clone [https://github.com/philippft/tempe-iris.git](https://github.com/philippft/tempe-iris.git)
cd tempe-iris
```

### 2. Install Dependencies
```bash
Pasang semua package PHP dan JavaScript yang dibutuhkan oleh aplikasi:
composer install
npm install
```

### 3. Setup Environment File
Salin file konfigurasi lingkungan dasar dari `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```

### 4. Konfigurasi Database
A. Nyalakan panel control **Laragon**, lalu klik tombol **Start All** (Pastikan layanan Apache dan MySQL berjalan).

B. Buka aplikasi database manager favorit Anda (seperti HeidiSQL atau phpMyAdmin) lalu buat sebuah database baru bernama **`tempe_iris`**.

C. Buka file `.env` yang baru saja dibuat menggunakan text editor Anda, lalu sesuaikan konfigurasi database Anda pada baris berikut:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tempe_iris
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generate Application Key
Jalankan perintah berikut untuk membuat kunci pengaman (*security key*) aplikasi unik di dalam file `.env`:
```bash
php artisan key:generate
```

### 5. Generate Application Key
Jalankan perintah berikut untuk membuat kunci pengaman (*security key*) aplikasi unik di dalam file `.env`:
```bash
php artisan key:generate
```
---

## ⚡ Menjalankan Aplikasi

Setelah seluruh proses konfigurasi di atas selesai, Anda dapat menjalankan aplikasi dengan membuka dua jendela terminal terpisah:

* **Terminal 1 (Menjalankan Server Lokal Laravel):**
    ```bash
    php artisan serve
    ```
    Aplikasi kini dapat diakses secara lokal melalui browser Anda di alamat `http://127.0.0.1:8000` atau via alamat domain otomatis Laragon di `http://tempe-iris.test`.

* **Terminal 2 (Menjalankan Asset Compiler Vite):**
    ```bash
    npm run dev
    ```
    Terminal ini akan mendeteksi setiap perubahan file CSS atau JS di frontend secara langsung (*hot-reloading*).

---

## 🤝 Kontribusi

Kontribusi selalu terbuka lebar untuk meningkatkan kualitas project ini! Jika Anda ingin berkontribusi:

1. Lakukan **Fork** pada repository ini.
2. Buat branch fitur baru Anda (`git checkout -b fitur/FiturKerenAnda`).
3. Lakukan *commit* terhadap perubahan Anda (`git commit -m 'Menambahkan Fitur Keren Anda'`).
4. *Push* branch tersebut ke GitHub (`git push origin fitur/FiturKerenAnda`).
5. Buka sebuah **Pull Request** untuk kami tinjau lebih lanjut.

Pastikan kode Anda tetap rapi dengan menjalankan linter bawaan project sebelum melakukan commit:
```bash
./vendor/bin/pint
