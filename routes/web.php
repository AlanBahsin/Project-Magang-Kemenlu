<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VerifikatorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\KredensialController;
use App\Http\Controllers\Admin\LaporanController;

Route::get('/', fn () => redirect('/login'));

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {

    // 🔁 REDIRECT DASHBOARD SESUAI ROLE
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;

        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($role === 'verifikator') {
            return redirect()->route('verifikator.dashboard');
        }

        return redirect()->route('user.dashboard');
    })->name('dashboard');


    // ================= ADMIN =================
    Route::middleware(['role:admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

        // DASHBOARD
        Route::get('/dashboard', [AdminController::class,'index'])->name('dashboard');

        // KREDENSIAL
        Route::get('/kredensial', [KredensialController::class,'index'])->name('kredensial.index');
        Route::post('/kredensial', [KredensialController::class,'store'])->name('kredensial.store');
        Route::put('/kredensial/{id}', [KredensialController::class,'update'])->name('kredensial.update');
        Route::delete('/kredensial/{id}', [KredensialController::class,'destroy'])->name('kredensial.destroy');

        Route::post('/kredensial/{id}/approve', [KredensialController::class,'approve'])->name('kredensial.approve');
        Route::post('/kredensial/{id}/reject', [KredensialController::class,'reject'])->name('kredensial.reject');

        // LAPORAN
        Route::get('/laporan', [LaporanController::class,'index'])->name('laporan');
        Route::get('/laporan/export-pdf', [LaporanController::class,'exportPdf'])->name('laporan.pdf');

        // MENU LAIN (sementara view)
        Route::view('/negara', 'pages.admin.negara.index')->name('negara');
        Route::view('/notifikasi', 'pages.admin.notifikasi.index')->name('notifikasi');
        Route::view('/pengaturan', 'pages.admin.pengaturan.index')->name('pengaturan');

    });


    // ================= VERIFIKATOR =================
    Route::middleware(['role:verifikator'])->group(function () {
        Route::get('/verifikator/dashboard', [VerifikatorController::class,'index'])
            ->name('verifikator.dashboard');
    });


    // ================= USER =================
    Route::middleware(['role:user'])->group(function () {
        Route::get('/user/dashboard', [UserController::class,'index'])
            ->name('user.dashboard');
    });
    Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])
    ->name('laporan.excel');

});