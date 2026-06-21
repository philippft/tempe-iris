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

Route::middleware(['auth', 'isPetinggi'])->group(function () {
    Route::get('/petinggi_dekanat/dashboard', [PetinggiDashboardController::class, 'petinggiDashboard'])->name('petinggi_dekanat.dashboard');
});

Route::get('/preview-sidebar', function () {
    // Simulasi user & role sesukamu
    $fakeUser = new \App\Models\User([
        'name'    => 'Admin Dekanat',
        'role'    => 'admin_dekanat', // ganti: admin_lm | mahasiswa | petinggi_dekanat
        'nim'     => '2408561030',
        'jabatan' => 'Wakil Dekan III',
    ]);

    Auth::login($fakeUser); // login sementara tanpa password
    return view('preview-sidebar');
});

// Route::get('/register', [AuthController::class, 'registerView'])->name('register');
// Route::post('/register', [AuthController::class, 'register'])->name('register.post');
