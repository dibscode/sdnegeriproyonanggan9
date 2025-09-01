<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Public berita listing
Route::get('/beritas', [App\Http\Controllers\BeritaController::class, 'publicIndex'])->name('public.beritas.index');
// Public berita detail
Route::get('/beritas/{berita}', [App\Http\Controllers\BeritaController::class, 'publicShow'])->name('public.beritas.show');

// Protected routes for the app flows
Route::middleware(['auth'])->group(function () {
    // Admin-only routes
    Route::middleware(['can:isAdmin'])->group(function () {
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::resource('gurus', App\Http\Controllers\Admin\GuruController::class)->except(['show']);
            Route::get('gurus/template', [App\Http\Controllers\Admin\GuruController::class, 'template'])->name('gurus.template');
            Route::post('gurus/import', [App\Http\Controllers\Admin\GuruController::class, 'import'])->name('gurus.import');
            Route::resource('murids', App\Http\Controllers\Admin\MuridController::class)->except(['show']);
            Route::resource('mata_pelajarans', App\Http\Controllers\Admin\MataPelajaranController::class)->except(['show']);
            Route::get('murids/template', [App\Http\Controllers\Admin\MuridController::class, 'template'])->name('murids.template');
            Route::post('murids/import', [App\Http\Controllers\Admin\MuridController::class, 'import'])->name('murids.import');
            Route::post('murids/backfill', [App\Http\Controllers\Admin\MuridController::class, 'backfill'])->name('murids.backfill');
            Route::get('murids/json', [App\Http\Controllers\Admin\MuridController::class, 'json'])->name('murids.json');
            Route::resource('kelas', App\Http\Controllers\Admin\KelasController::class)->parameters(['kelas' => 'kelas'])->except(['show']);
        });
    });

    // Wali guru (guru) responsibilities
    Route::middleware(['can:isGuru'])->group(function () {
        // Existing generic NilaiController kept for admin-ish listing
        Route::resource('nilais', App\Http\Controllers\NilaiController::class)->only(['index','store','update','destroy']);

        // Guru-specific nilai flow: list kelas (where guru is wali), list murid per kelas, edit nilai per murid
        Route::prefix('guru')->name('guru.')->group(function () {
            Route::get('nilais/kelas', [App\Http\Controllers\Guru\NilaiController::class, 'kelasIndex'])->name('nilais.kelas');
            Route::get('nilais/kelas/{kelas}', [App\Http\Controllers\Guru\NilaiController::class, 'muridIndex'])->name('nilais.murid.index');
            Route::get('nilais/murid/{murid}', [App\Http\Controllers\Guru\NilaiController::class, 'edit'])->name('nilais.murid.edit');
            Route::post('nilais/murid/{murid}', [App\Http\Controllers\Guru\NilaiController::class, 'store'])->name('nilais.murid.store');
            // Bulk save multiple mapel values for one murid (single submit)
            Route::post('nilais/murid/{murid}/bulk', [App\Http\Controllers\Guru\NilaiController::class, 'bulkStore'])->name('nilais.murid.bulk');
            Route::put('nilais/{nilai}', [App\Http\Controllers\Guru\NilaiController::class, 'update'])->name('nilais.update');
            Route::delete('nilais/{nilai}', [App\Http\Controllers\Guru\NilaiController::class, 'destroy'])->name('nilais.destroy');
            // Guru-managed berita CRUD (moved under /guru prefix so public /beritas remains available)
            Route::resource('beritas', App\Http\Controllers\BeritaController::class)->except(['show']);
        });
        Route::resource('jadwals', App\Http\Controllers\JadwalController::class)->except(['show']);
        Route::resource('galleries', App\Http\Controllers\GalleryController::class)->except(['show']);
    });

    // Murid (student) views
    Route::middleware(['can:isMurid'])->group(function () {
        Route::get('murid/dashboard', [App\Http\Controllers\MuridController::class, 'dashboard'])->name('murid.dashboard');
    Route::get('murid/nilai/pdf', [App\Http\Controllers\MuridController::class, 'nilaiPdf'])->name('murid.nilai.pdf');
    });
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
