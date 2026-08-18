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

    public function showInvestorWallet(Request $request): JsonResponse
    {
        $investorId = $request->user_id; // Dari middleware (Investor)
        
        $wallet = InvestorDividenWallet::firstOrCreate(
            ['investor_id' => $investorId], 
            ['saldo_dividen' => 0]
        );
        
        // Mutasi tidak ada pada model InvestorDividenWallet saat ini (bisa dikembangkan nanti)
        
        return $this->successResponse(new WalletResource($wallet), 'Berhasil mengambil dompet Investor.');
    }
}
