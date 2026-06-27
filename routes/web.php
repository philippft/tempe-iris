<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DekanatDashboardController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PetinggiDashboardController;
use App\Http\Controllers\UserDashboardController;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'registerView'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');


Route::middleware(['auth', 'isUser'])->prefix('mahasiswa')->name('user.')->group(function () {
    Route::controller(UserDashboardController::class)->group(function () {
        Route::get('/akun/detail/{user:id}', 'detailAkun')->name('detail-akun');
        // Route::get('/akun/detail/{user:id}/edit', 'detailAkunForm')->name('detail-akun.edit');
        Route::put('/akun/detail/{user:id}', [UserDashboardController::class, 'detailAkunEdit'])->name('detail-akun.update');

        Route::get('/dashboard', 'userDashboard')->name('dashboard');
        Route::get('/peminjaman', 'index')->name('peminjaman.index');
        Route::get('/peminjaman/create', 'create')->name('peminjaman.create');
        Route::delete('/peminjaman/delete/{surat}', 'destroy')->name('peminjaman.destroy');

        Route::get('/peminjaman/detail/{surat}', 'detailPeminjaman')->name('peminjaman.detail-surat');
        Route::post('/peminjaman/add-detail', 'addDetailPeminjaman')->name('peminjaman.detail');

        Route::get('/peminjaman/create/kegiatan/{surat}', 'kegiatan')->name('peminjaman.kegiatan');
        Route::put('/peminjaman/add-kegiatan/{surat}', 'addKegiatan')->name('peminjaman.add.kegiatan');

        Route::get('/peminjaman/create/detail-kegiatan/{surat}', 'detailKegiatan')->name('peminjaman.detail.kegiatan');
        Route::put('/peminjaman/add-detail-kegiatan/{surat}', 'addDetailKegiatan')->name('peminjaman.store.kegiatan');

        Route::put('/peminjaman/verifikasi/{surat}', 'verifikasiSurat')->name('peminjaman.verifikasi');
    });
    Route::get('/download-surat/{surat}', [PdfController::class, 'downloadSurat'])->name('download.surat');
});

Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'adminDashboard'])->name('dashboard');

    // Inventaris
    Route::resource('inventaris', InventarisController::class)->parameters([
        'inventaris' => 'inventaris'
    ]);;

    // Peminjaman
    Route::controller(PeminjamanController::class)->group(function () {
        Route::get('/peminjaman', 'index')->name('peminjaman.index');
        Route::get('/peminjaman/create', 'create')->name('peminjaman.create');
        Route::delete('/peminjaman/delete/{surat}', 'destroy')->name('peminjaman.destroy');

        Route::get('/peminjaman/detail/{surat}', 'detailPeminjaman')->name('peminjaman.detail-surat');
        Route::post('/peminjaman/add-detail', 'addDetailPeminjaman')->name('peminjaman.detail');

        Route::get('/peminjaman/create/kegiatan/{surat}', 'kegiatan')->name('peminjaman.kegiatan');
        Route::put('/peminjaman/add-kegiatan/{surat}', 'addKegiatan')->name('peminjaman.add.kegiatan');

        Route::get('/peminjaman/create/detail-kegiatan/{surat}', 'detailKegiatan')->name('peminjaman.detail.kegiatan');
        Route::put('/peminjaman/add-detail-kegiatan/{surat}', 'addDetailKegiatan')->name('peminjaman.store.kegiatan');

        Route::put('/peminjaman/verifikasi/{surat}', 'verifikasiSurat')->name('peminjaman.verifikasi');
    });

    Route::get('/management-user', [AdminDashboardController::class, 'managementUser'])->name('management.user');
    Route::get('/management-user/detail/{user}', [AdminDashboardController::class, 'userDetail'])->name('user.detail');

    Route::put('/user/approve/{user}', [AdminDashboardController::class, 'approveUser'])->name('user.approve')->middleware('throttle:2,1');;

    Route::get('/download-surat/{surat}', [PdfController::class, 'downloadSurat'])->name('download.surat');

});
    
Route::middleware(['auth', 'isDekanat'])->prefix('dekanat')->name('dekanat.')->group(function () {

    Route::controller(DekanatDashboardController::class)->group(function () {
        Route::get('/dashboard','dekanatDashboard')->name('dashboard');

        Route::get('/peminjaman', 'index')->name('peminjaman.index');
        Route::get('/peminjaman/detail/{surat}', 'detailPeminjaman')->name('peminjaman.detail-surat');

        Route::put('/peminjaman/verifikasi/{surat}', 'verifikasiSurat')->name('peminjaman.verifikasi');
    });

    Route::get('/download-surat/{surat}', [PdfController::class, 'downloadSurat'])->name('download.surat');

    // Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');

    Route::get('/inventaris', [InventarisController::class, 'index'])->name('inventaris.index');
});

Route::middleware(['auth', 'isPetinggi'])->prefix('petinggi')->name('petinggi.')->group(function () {
    Route::get('/dashboard', [PetinggiDashboardController::class, 'petinggiDashboard'])->name('dashboard');

    Route::get('/surat', [PetinggiDashboardController::class, 'suratIndex'])->name('surat.index');
});


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