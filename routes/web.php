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

<<<<<<< HEAD
    // Register
    Route::get('/register', [AuthController::class, 'registerView'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});
=======
Route::get('/register', [AuthController::class, 'registerView'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
>>>>>>> 8585edc6e68e8e92e8e842dd694a894aab4935da


Route::middleware(['auth', 'isUser'])->prefix('mahasiswa')->name('user.')->group(function () {
    Route::controller(UserDashboardController::class)->group(function () {
        Route::get('/akun/detail/{user:id}', 'detailAkun')->name('detail-akun');
        Route::get('/akun/detail/{user:id}/edit', 'detailAkunForm')->name('detail-akun.edit');
        Route::put('/akun/detail/{user:id}', 'detailAkunEdit')->name('detail-akun.update');

        Route::get('/dashboard', 'userDashboard')->name('dashboard');
        Route::get('/peminjaman', 'index')->name('peminjaman.index');
        Route::get('/peminjaman/create', 'create')->name('peminjaman.create');
        Route::get('/peminjaman/detail/{surat}', 'detailPeminjaman')->name('peminjaman.detail-surat');
        Route::post('/peminjaman/add-detail', 'addDetailPeminjaman')->name('peminjaman.detail');

        Route::get('/peminjaman/create/kegiatan/{surat}', 'kegiatan')->name('peminjaman.kegiatan');
        Route::put('/peminjaman/add-kegiatan/{surat}', 'addKegiatan')->name('peminjaman.add.kegiatan');

        Route::get('/peminjaman/create/detail-kegiatan/{surat}', 'detailKegiatan')->name('peminjaman.detail.kegiatan');
        Route::put('/peminjaman/add-detail-kegiatan/{surat}', 'addDetailKegiatan')->name('peminjaman.store.kegiatan');
    });
<<<<<<< HEAD
    Route::get('/surat/{surat}/preview',[PdfController::class,'previewSurat'])->name('preview.surat');
=======
>>>>>>> 8585edc6e68e8e92e8e842dd694a894aab4935da
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
        Route::get('/peminjaman/detail/{surat}', 'detailPeminjaman')->name('peminjaman.detail-surat');
        Route::post('/peminjaman/add-detail', 'addDetailPeminjaman')->name('peminjaman.detail');

        Route::get('/peminjaman/create/kegiatan/{surat}', 'kegiatan')->name('peminjaman.kegiatan');
        Route::put('/peminjaman/add-kegiatan/{surat}', 'addKegiatan')->name('peminjaman.add.kegiatan');

        Route::get('/peminjaman/create/detail-kegiatan/{surat}', 'detailKegiatan')->name('peminjaman.detail.kegiatan');
        Route::put('/peminjaman/add-detail-kegiatan/{surat}', 'addDetailKegiatan')->name('peminjaman.store.kegiatan');
    });

    Route::get('/management-user', [AdminDashboardController::class, 'managementUser'])->name('management.user');
    Route::get('/management-user/detail/{user}', [AdminDashboardController::class, 'userDetail'])->name('user.detail');

    Route::put('/user/approve/{user}', [AdminDashboardController::class, 'approveUser'])->name('user.approve')->middleware('throttle:2,1');;
    
    Route::get('/surat/{surat}/preview',[PdfController::class,'previewSurat'])->name('preview.surat');
    Route::get('/download-surat/{surat}', [PdfController::class, 'downloadSurat'])->name('download.surat');

});
    
Route::middleware(['auth', 'isDekanat'])->prefix('dekanat')->name('dekanat.')->group(function () {
    Route::get('/dashboard', [DekanatDashboardController::class, 'dekanatDashboard'])->name('dashboard');

    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');

        Route::get('/peminjaman', 'index')->name('peminjaman.index');
        Route::get('/peminjaman/detail/{surat}', 'detailPeminjaman')->name('peminjaman.detail-surat');

        Route::put('/peminjaman/verifikasi/{surat}', 'verifikasiSurat')->name('peminjaman.verifikasi');
        Route::delete('/peminjaman/delete/{surat}', 'destroy')->name('peminjaman.destroy');
    });
    Route::get('/surat/{surat}/preview', [PdfController::class, 'previewSurat'])->name('preview.surat');
    // Download Surat
    Route::get('/download-surat/{surat}', [PdfController::class, 'downloadSurat'])->name('download.surat');

    // Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');

    Route::resource('inventaris', DekanatInventarisController::class)->parameters([
        'inventaris' => 'inventaris'
    ]);
});

Route::middleware(['auth', 'isPetinggi'])->prefix('petinggi')->name('petinggi.')->group(function () {
    Route::get('/dashboard', [PetinggiDashboardController::class, 'petinggiDashboard'])->name('dashboard');
    Route::get('/surat', [PetinggiDashboardController::class, 'suratDashboard'])->name('surat.index');
    Route::get('/peminjaman/{surat}', [PetinggiDashboardController::class, 'show'])->name('peminjaman.detail-surat');
    // Route::get('/peminjaman/{surat}', [PetinggiDashboardController::class, 'detailPeminjaman'])->name('surat.show');
    Route::put('/surat/{surat}/verifikasi', [PetinggiDashboardController::class, 'verifikasiSurat'])->name('surat.verifikasi');
    Route::get('/surat/{surat}/download',  [PdfController::class, 'downloadSurat'])->name('surat.download'); 
    Route::get('/surat/{surat}/preview', [PdfController::class, 'previewSurat'])->name('preview.surat');
    Route::delete('/surat/{surat}', [PeminjamanController::class, 'destroy'])->name('surat.destroy');
});


// Route::get('/register', [AuthController::class, 'registerView'])->name('register');
// Route::post('/register', [AuthController::class, 'register'])->name('register.post');