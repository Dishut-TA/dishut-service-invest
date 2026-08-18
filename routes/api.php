<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProgramInvestasiController;
use App\Http\Controllers\Api\VerifikasiProgramController;
use App\Http\Controllers\Api\PendanaanController;
use App\Http\Controllers\Api\LaporanProyekController;
use App\Http\Controllers\Api\LaporanKeuanganController;
use App\Http\Controllers\Api\PenarikanDividenController;
use App\Http\Controllers\Api\WalletController;

// ---------------------------------------------------------
// PUBLIC / CATALOG ROUTES
// ---------------------------------------------------------
Route::get('/programs', [ProgramInvestasiController::class, 'index']);
Route::get('/programs/{id}', [ProgramInvestasiController::class, 'show']);

// ---------------------------------------------------------
// WEBHOOK (Payment Gateway Callback - NO AUTH REQUIRED)
// ---------------------------------------------------------
Route::post('/pendanaan/webhook', [PendanaanController::class, 'webhook']);

// ---------------------------------------------------------
// PROTECTED ROUTES (Requires JWT from service-user)
// ---------------------------------------------------------
// Asumsi: Anda akan membuat/menggunakan middleware custom
// untuk parsing JWT (misal namanya 'auth.jwt').
Route::middleware(['auth.jwt'])->group(function () {
    
    // === ROLE: KTH ===
    Route::prefix('kth')->group(function () {
        Route::get('/programs', [ProgramInvestasiController::class, 'indexKth']);
        Route::post('/programs', [ProgramInvestasiController::class, 'store']);
        
        Route::post('/laporan-proyek', [LaporanProyekController::class, 'store']);
        Route::post('/laporan-keuangan', [LaporanKeuanganController::class, 'store']);
        
        Route::get('/wallet', [WalletController::class, 'showKthWallet']);
    });

    // === ROLE: INVESTOR ===
    Route::prefix('investor')->group(function () {
        Route::post('/pendanaan', [PendanaanController::class, 'store']);
        Route::post('/penarikan-dividen', [PenarikanDividenController::class, 'store']);
        Route::get('/wallet', [WalletController::class, 'showInvestorWallet']);
    });

    // === ROLE: BUPM STAFF & HEAD ===
    Route::prefix('bupm')->group(function () {
        Route::put('/programs/{id}/verify', [VerifikasiProgramController::class, 'verify']);
        Route::put('/laporan-proyek/{id}/verify', [LaporanProyekController::class, 'verify']);
        Route::put('/laporan-keuangan/{id}/verify', [LaporanKeuanganController::class, 'verify']);
        Route::put('/penarikan-dividen/{id}/process', [PenarikanDividenController::class, 'process']);
    });

});
