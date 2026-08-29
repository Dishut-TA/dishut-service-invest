<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WalletResource;
use App\Models\KthWallet;
use App\Models\InvestorDividenWallet;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Traits\ApiResponse;

class WalletController extends Controller
{
    use ApiResponse;

    public function showKthWallet(Request $request): JsonResponse
    {
        $userId = $request->user_id; // Dari middleware (User KTH)
        
        $wallet = KthWallet::with('mutasis')
                    ->firstOrCreate(['user_id' => $userId], ['saldo_tersedia' => 0]);

        return $this->successResponse(new WalletResource($wallet), 'Berhasil mengambil dompet KTH.');
    }

    public function topupKthWallet(Request $request): JsonResponse
    {
        $request->validate([
            'nominal_topup' => 'required|numeric|min:1',
            'metode_pembayaran' => 'required|string|max:100',
        ]);

        $userId = $request->user_id;
        
        $wallet = KthWallet::firstOrCreate(['user_id' => $userId], ['saldo_tersedia' => 0]);
        $wallet->increment('saldo_tersedia', $request->nominal_topup);
        
        $wallet->mutasis()->create([
            'tipe_mutasi' => 'KREDIT',
            'nominal' => $request->nominal_topup,
            'metode_pembayaran' => $request->metode_pembayaran,
            'keterangan' => 'Topup saldo'
        ]);

        return $this->successResponse(new WalletResource($wallet->load('mutasis')), 'Berhasil topup dompet KTH.');
    }

    public function showInvestorWallet(Request $request): JsonResponse
    {
        $investorId = $request->user_id; // Dari middleware (Investor)
        
        $wallet = InvestorDividenWallet::with('mutasis')->firstOrCreate(
            ['investor_id' => $investorId], 
            ['saldo_dividen' => 0]
        );
        
        return $this->successResponse(new WalletResource($wallet), 'Berhasil mengambil dompet Investor.');
    }

    public function topupInvestorWallet(Request $request): JsonResponse
    {
        $request->validate([
            'nominal_topup' => 'required|numeric|min:1',
            'metode_pembayaran' => 'required|string|max:100',
        ]);

        $investorId = $request->user_id;
        
        $wallet = InvestorDividenWallet::firstOrCreate(['investor_id' => $investorId], ['saldo_dividen' => 0]);
        $wallet->increment('saldo_dividen', $request->nominal_topup);
        
        $wallet->mutasis()->create([
            'tipe_mutasi' => 'KREDIT',
            'nominal' => $request->nominal_topup,
            'metode_pembayaran' => $request->metode_pembayaran,
            'keterangan' => 'Topup saldo'
        ]);

        return $this->successResponse(new WalletResource($wallet->load('mutasis')), 'Berhasil topup dompet Investor.');
    }
}
