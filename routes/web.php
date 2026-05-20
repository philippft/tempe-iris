<?php

use App\Http\Controllers\AdminDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DekanatDashboardController;
use App\Http\Controllers\PetinggiDashboardController;
use App\Http\Controllers\UserDashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/user/dashboard', [UserDashboardController::class, 'userDashboard'])->name('mahasiswa.dashboard');
Route::get('/admin_lm/dashboard', [AdminDashboardController::class, 'adminDashboard'])->name('admin_lm.dashboard');
Route::get('/admin_dekanat/dashboard', [DekanatDashboardController::class, 'dekanatDashboard'])->name('admin_dekanat.dashboard');
Route::get('/petinggi_dekanat/dashboard', [PetinggiDashboardController::class, 'petinggiDashboard'])->name('petinggi_dekanat.dashboard');
// Route::get('/register', [AuthController::class, 'registerView'])->name('register');
// Route::post('/register', [AuthController::class, 'register'])->name('register.post');
