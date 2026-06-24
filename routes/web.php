<?php

use App\Http\Controllers\AdminDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DekanatDashboardController;
use App\Http\Controllers\PetinggiDashboardController;
use App\Http\Controllers\UserDashboardController;

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'isUser'])->group(function () {
    Route::get('/user/dashboard', [UserDashboardController::class, 'userDashboard'])->name('mahasiswa.dashboard');
});

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin_lm/dashboard', [AdminDashboardController::class, 'adminDashboard'])->name('admin_lm.dashboard');
});
    
Route::middleware(['auth', 'isDekanat'])->group(function () {
    Route::get('/admin_dekanat/dashboard', [DekanatDashboardController::class, 'dekanatDashboard'])->name('admin_dekanat.dashboard');
});

    $menus = [
        [
            'label'  => 'Dashboard',
            'route'  => 'dashboard',
            'roles'  => ['admin_dekanat', 'admin_lm', 'mahasiswa', 'petinggi_dekanat'],
            'icon'   => 'dashboard',
        ],
        [
            'label'  => 'Peminjaman',
            'route'  => 'peminjaman.index',
            'roles'  => ['admin_dekanat', 'admin_lm', 'mahasiswa'],
            'icon'   => 'transfer',
        ],
        [
            'label'  => 'Manajemen User',
            'route'  => 'manajemen-user.index',
            'roles'  => ['admin_lm'],
            'icon'   => 'users',
        ],
        [
            'label'  => 'Manajemen Inventaris',
            'route'  => 'manajemen-inventaris.index',
            'roles'  => ['admin_dekanat', 'admin_lm'],
            'icon'   => 'archive',
        ],
        [
            'label'  => 'Manajemen Surat',
            'route'  => 'manajemen-surat.index',
            'roles'  => ['admin_dekanat', 'admin_lm', 'mahasiswa', 'petinggi_dekanat'],
            'icon'   => 'document',
        ],

// Fake Data Punya LEO
// MULAI

    Route::get('/preview', function () {
        return view('preview');
    });

    // BELUM SELESAI
    Route::get('/pilih-barang', function () {
        return view('pilihbarang');
    });

// SELESAI


// Route::get('/register', [AuthController::class, 'registerView'])->name('register');
// Route::post('/register', [AuthController::class, 'register'])->name('register.post');
