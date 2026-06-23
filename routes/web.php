<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DekanatDashboardController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\PetinggiDashboardController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'isUser'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'userDashboard'])->name('dashboard');
});

Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'adminDashboard'])->name('dashboard');
    Route::resource('inventaris', InventarisController::class)->parameters([
        'inventaris' => 'inventaris'
    ]);;
});
    
Route::middleware(['auth', 'isDekanat'])->prefix('dekanat')->name('dekanat.')->group(function () {
    Route::get('/dashboard', [DekanatDashboardController::class, 'dekanatDashboard'])->name('dashboard');
});

Route::middleware(['auth', 'isPetinggi'])->prefix('petinggi')->name('petinggi.')->group(function () {
    Route::get('/dashboard', [PetinggiDashboardController::class, 'petinggiDashboard'])->name('dashboard');
});

// Route::get('/register', [AuthController::class, 'registerView'])->name('register');
// Route::post('/register', [AuthController::class, 'register'])->name('register.post');
