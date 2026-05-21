<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

📌 README - Tempe Iris (Laravel Project)
🚀 Cara Menjalankan Project

Ikuti langkah-langkah berikut untuk menjalankan project Laravel ini di local:

1. 🧩 Persiapan Awal

Pastikan sudah menginstall:

PHP >= 8.4
Composer
Node.js & NPM
Laragon (atau XAMPP, tapi disarankan Laragon)
2. ⚡ Menyalakan Server
Jalankan Laragon
Klik Start All
3. 📥 Clone Repository
git clone https://github.com/philippft/tempe-iris.git
cd tempe-iris
4. 📦 Install Dependency
Backend (Laravel)
composer install
Frontend
npm install
5. ⚙️ Konfigurasi Environment

Copy file .env:

cp .env.example .env

Lalu generate key:

php artisan key:generate
6. 🗄️ Setting Database

Buka file .env, lalu ubah bagian berikut (baris 23–28):

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_kamu
DB_USERNAME=root
DB_PASSWORD=

📌 Pastikan:

Database sudah dibuat di phpMyAdmin / MySQL
Nama database sesuai
7. 🧱 Migrasi Database
php artisan migrate

Kalau ada seeder:

php artisan db:seed
8. ▶️ Jalankan Project
Laravel Server
php artisan serve
Frontend (Vite)
npm run dev
9. 🌐 Akses Aplikasi

Buka di browser:

http://127.0.0.1:8000