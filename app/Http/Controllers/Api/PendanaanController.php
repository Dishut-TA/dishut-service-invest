<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePendanaanRequest;
use App\Http\Resources\TransaksiPendanaanResource;
use App\Services\PendanaanService;
use App\Models\TransaksiPendanaan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PendanaanController extends Controller
{
    public function __construct(
        private PendanaanService $pendanaanService
    ) {}

    public function store(StorePendanaanRequest $request): JsonResponse
    {
        try {
            $investorId = $request->user_id; // Dari middleware / token
            $transaksi = $this->pendanaanService->initializePayment($request->validated(), $investorId);
            
            return response()->json([
                'message' => 'Transaksi pendanaan berhasil diinisialisasi. Lanjutkan ke pembayaran.',
                'data' => new TransaksiPendanaanResource($transaksi)
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function webhook(Request $request): JsonResponse
    {
        // Simulasi webhook dari Payment Gateway
        $transaksiId = $request->input('transaksi_id');
        $transaksi = TransaksiPendanaan::findOrFail($transaksiId);
        
        try {
            $this->pendanaanService->handlePaymentSuccess($transaksi);
            return response()->json(['message' => 'Webhook berhasil diproses.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
