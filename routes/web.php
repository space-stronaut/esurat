<?php

use App\Http\Controllers\Admin\PendudukController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\Admin\ValidationController;

// ... (Route lain yang sudah ada) ...

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('penduduk', PendudukController::class);
    
    // Rute Validasi User Sprint 2
    Route::get('validasi', [ValidationController::class, 'index'])->name('validasi.index');
    Route::post('validasi/{user}/approve', [ValidationController::class, 'approve'])->name('validasi.approve');
    Route::post('validasi/{user}/reject', [ValidationController::class, 'reject'])->name('validasi.reject');
});

use App\Http\Controllers\Admin\SuratTemplateController;

// ... (Route lain yang sudah ada dari Sprint 1 dan 2) ...

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Sprint 1
    Route::resource('penduduk', PendudukController::class);
    
    // Sprint 2
    Route::get('validasi', [ValidationController::class, 'index'])->name('validasi.index');
    // ...
    
    // Rute Template Surat Sprint 3
    Route::resource('template', SuratTemplateController::class)->except(['show', 'edit', 'update']); // Edit dan Update bisa ditambahkan jika diperlukan nanti
});

use App\Http\Controllers\User\PengajuanController as UserPengajuanController;
use App\Http\Controllers\Admin\PemrosesanSuratController;

// ...

// Grup Route untuk User Terverifikasi
Route::middleware(['auth', 'verified'])->prefix('user')->name('user.')->group(function () {
    Route::resource('pengajuan', UserPengajuanController::class)->only(['index', 'create', 'store']);
    Route::post('pengajuan/{pengajuan}/cancel', [UserPengajuanController::class, 'cancel'])->name('pengajuan.cancel');
    Route::get('get-template/{id}', [UserPengajuanController::class, 'getTemplateData']);
});

// Grup Route untuk Admin
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // ... rute sebelumnya (penduduk, template, validasi) ...
    
    Route::resource('pemrosesan', PemrosesanSuratController::class)->only(['index', 'edit', 'update']);
});

use App\Http\Controllers\SuperAdmin\ProfilKantorController;

// ...

use App\Http\Controllers\SuperAdmin\AdminManagementController;

// ... (Route User dan Admin sebelumnya) ...

// Grup Route KHUSUS Super Admin
Route::middleware(['auth'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::resource('admins', AdminManagementController::class)->except(['show', 'edit', 'update']);
});

Route::middleware(['auth'])->prefix('superadmin')->name('superadmin.')->group(function () {
    
    // Route Manajemen Admin (Yang sebelumnya)
    // Route::resource('admins', AdminManagementControlle::class)->except(['show', 'edit', 'update']);
    
    // Route Pengaturan Profil Kantor (TUGAS SPRINT 1 YANG TERLEWAT)
    Route::get('profil-kantor', [ProfilKantorController::class, 'edit'])->name('profil.edit');
    Route::put('profil-kantor', [ProfilKantorController::class, 'update'])->name('profil.update');

});

// ...
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // ...
    // MANAJEMEN PEMROSESAN SURAT (ALUR BARU)
    Route::get('pemrosesan', [\App\Http\Controllers\Admin\PemrosesanSuratController::class, 'index'])->name('pemrosesan.index');
    
    // Tahap 1: Verifikasi
    Route::get('pemrosesan/{pemrosesan}/verifikasi', [\App\Http\Controllers\Admin\PemrosesanSuratController::class, 'verifikasi'])->name('pemrosesan.verifikasi');
    Route::post('pemrosesan/{pemrosesan}/verifikasi', [\App\Http\Controllers\Admin\PemrosesanSuratController::class, 'processVerifikasi'])->name('pemrosesan.process_verifikasi');
    
    // Tahap 2: Drafting
    Route::get('pemrosesan/{pemrosesan}/drafting', [\App\Http\Controllers\Admin\PemrosesanSuratController::class, 'drafting'])->name('pemrosesan.drafting');
    Route::post('pemrosesan/{pemrosesan}/drafting', [\App\Http\Controllers\Admin\PemrosesanSuratController::class, 'processDrafting'])->name('pemrosesan.process_drafting');
    
    // Tahap 3: Menunggu TTD & Selesai
    Route::get('pemrosesan/{pemrosesan}/unduh-draft', [\App\Http\Controllers\Admin\PemrosesanSuratController::class, 'unduhDraft'])->name('pemrosesan.unduh_draft');
    Route::post('pemrosesan/{pemrosesan}/selesai-ttd', [\App\Http\Controllers\Admin\PemrosesanSuratController::class, 'selesaiTtd'])->name('pemrosesan.selesai_ttd');
    Route::post('pemrosesan/{pemrosesan}/upload-final', [\App\Http\Controllers\Admin\PemrosesanSuratController::class, 'uploadGdrive'])->name('pemrosesan.upload_gdrive');

    // Pengajuan Offline (Biarkan seperti sebelumnya)
    Route::get('pengajuan-offline/create', [\App\Http\Controllers\Admin\PemrosesanSuratController::class, 'createOffline'])->name('pemrosesan.create_offline');
    Route::post('pengajuan-offline/store', [\App\Http\Controllers\Admin\PemrosesanSuratController::class, 'storeOffline'])->name('pemrosesan.store_offline');
    Route::get('pengajuan-offline/get-template/{id}', [\App\Http\Controllers\Admin\PemrosesanSuratController::class, 'getTemplateData']);
});

/* |--------------------------------------------------------------------------
| RUTE KHUSUS WARGA / USER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    
    Route::resource('pengajuan', \App\Http\Controllers\User\PengajuanController::class)->except(['edit', 'update']);
    Route::post('pengajuan/{pengajuan}/cancel', [\App\Http\Controllers\User\PengajuanController::class, 'cancel'])->name('pengajuan.cancel');
    Route::get('pengajuan/{pengajuan}/download', [\App\Http\Controllers\User\PengajuanController::class, 'downloadDocx'])->name('pengajuan.download');
    
    // PASTIKAN BARIS INI ADA AGAR FORM WARGA BISA MUNCUL:
    Route::get('pengajuan/get-template/{id}', [\App\Http\Controllers\User\PengajuanController::class, 'getTemplateData']);

    Route::get('pengajuan/{pengajuan}/perbaiki', [\App\Http\Controllers\User\PengajuanController::class, 'edit'])->name('pengajuan.edit');
    Route::put('pengajuan/{pengajuan}/perbaiki', [\App\Http\Controllers\User\PengajuanController::class, 'update'])->name('pengajuan.update');
    
});



require __DIR__.'/auth.php';
