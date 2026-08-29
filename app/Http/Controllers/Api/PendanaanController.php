<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePendanaanRequest;
use App\Http\Resources\TransaksiPendanaanResource;
use App\Services\PendanaanService;
use App\Models\TransaksiPendanaan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Traits\ApiResponse;

class PendanaanController extends Controller
{
    use ApiResponse;

    public function __construct(
        private PendanaanService $pendanaanService
    ) {}

    public function store(StorePendanaanRequest $request): JsonResponse
    {
        try {
            $investorId = $request->user_id; // Dari middleware / token
            $transaksi = $this->pendanaanService->initializePayment($request->validated(), $investorId);
            
            return $this->successResponse(new TransaksiPendanaanResource($transaksi), 'Transaksi pendanaan berhasil diinisialisasi. Lanjutkan ke pembayaran.', 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    public function webhook(Request $request): JsonResponse
    {
        // Simulasi webhook dari Payment Gateway
        $transaksiId = $request->input('transaksi_id');
        $transaksi = TransaksiPendanaan::findOrFail($transaksiId);
        
        try {
            $this->pendanaanService->handlePaymentSuccess($transaksi);
            return $this->successResponse(null, 'Webhook berhasil diproses.');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function riwayat(Request $request): JsonResponse
    {
        $investorId = $request->user_id; // Dari middleware / token
        
        $riwayat = TransaksiPendanaan::with(['program'])
            ->where('investor_id', $investorId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($trx) {
                return [
                    'tanggal_bayar' => $trx->tanggal_bayar,
                    'nama_investor' => $trx->nama,
                    'nama_program_investasi' => $trx->program->nama_program ?? null,
                    'status_pembayaran' => $trx->status_pembayaran,
                    'metode_pembayaran' => $trx->metode_pembayaran,
                    'total_nominal_pembayaran' => $trx->nominal_pendanaan,
                ];
            });
            
        return $this->successResponse($riwayat, 'Berhasil mengambil riwayat transaksi investasi.');
    }

    public function showRiwayat(Request $request, string $id): JsonResponse
    {
        $investorId = $request->user_id; // Dari middleware / token
        
        $transaksi = TransaksiPendanaan::with(['program'])
            ->where('investor_id', $investorId)
            ->findOrFail($id);
            
        return $this->successResponse(new TransaksiPendanaanResource($transaksi), 'Berhasil mengambil detail riwayat transaksi investasi.');
    }
}
