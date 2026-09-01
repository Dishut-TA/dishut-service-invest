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
        Route::get('/laporan-proyek', [LaporanProyekController::class, 'indexAdmin']);
        Route::get('/laporan-proyek/{id}', [LaporanProyekController::class, 'showAdmin']);
        Route::post('/laporan-keuangan', [LaporanKeuanganController::class, 'store']);
        Route::get('/laporan-keuangan', [LaporanKeuanganController::class, 'indexAdmin']);
        Route::get('/laporan-keuangan/{id}', [LaporanKeuanganController::class, 'showAdmin']);
        
        Route::get('/wallet', [WalletController::class, 'showKthWallet']);
        Route::post('/wallet/topup', [WalletController::class, 'topupKthWallet']);
    });

    // === ROLE: INVESTOR ===
    Route::prefix('investor')->group(function () {
        Route::post('/pendanaan', [PendanaanController::class, 'store']);
        Route::get('/riwayat-transaksi', [PendanaanController::class, 'riwayat']);
        Route::get('/riwayat-transaksi/{id}', [PendanaanController::class, 'showRiwayat']);
        Route::post('/penarikan-dividen', [PenarikanDividenController::class, 'store']);
        Route::get('/wallet', [WalletController::class, 'showInvestorWallet']);
        Route::post('/wallet/topup', [WalletController::class, 'topupInvestorWallet']);
    });

    // === ROLE: BUPM STAFF & HEAD (ADMIN) ===
    Route::prefix('bupm')->group(function () {
        // Program Investasi
        Route::get('/programs', [ProgramInvestasiController::class, 'indexAdmin']);
        Route::get('/programs/{id}', [ProgramInvestasiController::class, 'showAdmin']);
        Route::put('/programs/{id}/verify', [VerifikasiProgramController::class, 'verify']);
        
        // Laporan Proyek
        Route::get('/laporan-proyek', [LaporanProyekController::class, 'indexAdmin']);
        Route::get('/laporan-proyek/{id}', [LaporanProyekController::class, 'showAdmin']);
        Route::put('/laporan-proyek/{id}/verify', [LaporanProyekController::class, 'verify']);
        
        // Laporan Keuangan
        Route::get('/laporan-keuangan', [LaporanKeuanganController::class, 'indexAdmin']);
        Route::get('/laporan-keuangan/{id}', [LaporanKeuanganController::class, 'showAdmin']);
        Route::get('/laporan-keuangan/{id}/cetak', [LaporanKeuanganController::class, 'cetak']);
        Route::put('/laporan-keuangan/{id}/verify', [LaporanKeuanganController::class, 'verify']);
        
        // Penarikan Dividen
        Route::put('/penarikan-dividen/{id}/process', [PenarikanDividenController::class, 'process']);

        // Data Investor (Transaksi Pendanaan)
        Route::get('/investor', [PendanaanController::class, 'indexAdmin']);
        Route::get('/investor/{id}', [PendanaanController::class, 'showAdmin']);
        Route::put('/investor/{id}/verify', [PendanaanController::class, 'verifyPendanaan']);
    });

});
