<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Panduan Instalasi Project (Laravel)

Ikuti langkah-langkah di bawah ini untuk menjalankan project ini di komputer lokal Anda.

## Prasyarat (Prerequisites)
Sebelum memulai, pastikan perangkat Anda sudah menginstal dan menjalankan software berikut:
*   **PHP 8.4**
*   **Composer**
*   **Node.js & NPM**
*   **Laragon** (sebagai local server)

---

## Langkah-Langkah Instalasi

Silakan buka terminal atau Git Bash, lalu jalankan perintah berikut secara berurutan:

<Sequence>
{/* Reason: Urutan setup project Laravel sangat krusial; salah urutan (misal: generate key sebelum copy .env) akan menyebabkan error. */}
    <Step title="Clone Repository" subtitle="Langkah 1">
    1. Clone Repository
    Unduh source code project dari GitHub ke komputer lokal Anda:
    ```bash
    git clone [https://github.com/philippft/tempe-iris.git](https://github.com/philippft/tempe-iris.git)
    cd tempe-iris
    </Step>
    ### 2. Install Dependencies
    ```bash
    <Step title="Install Dependencies" subtitle="Langkah 2">
    composer i
    npm i
    </Step>
    ### 3. Setup Environment File
    ```bash
    <Step title="Setup Environment File" subtitle="Langkah 3">
    cp .env.example .env
    </Step>
    ### 4. Konfigurasi Database
    ```bash
    A. Nyalakan **Laragon**, lalu klik **Start All** (pastikan Apache dan MySQL jalan).

    B. Buka database manager (HeidiSQL/phpMyAdmin) dan buat database baru dengan nama `tempe_iris`.

    C. Buka file `.env` pakai text editor, lalu sesuaikan baris 23 sampai 28:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=tempe_iris
    DB_USERNAME=root
    DB_PASSWORD=