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

    public function indexAdmin(Request $request): JsonResponse
    {
        $query = TransaksiPendanaan::with(['program'])->orderBy('created_at', 'desc');
        $transaksis = $query->paginate(10);
        return $this->successResponse(TransaksiPendanaanResource::collection($transaksis)->response()->getData(true), 'Berhasil mengambil daftar data investor/pendanaan untuk admin');
    }

    public function showAdmin(string $id): JsonResponse
    {
        $transaksi = TransaksiPendanaan::with(['program'])->findOrFail($id);
        return $this->successResponse(new TransaksiPendanaanResource($transaksi), 'Berhasil mengambil detail data investor/pendanaan admin');
    }

    public function verifyPendanaan(Request $request, string $id): JsonResponse
    {
        $transaksi = TransaksiPendanaan::findOrFail($id);
        
        if ($transaksi->status_pembayaran !== 'PENDING') {
            return $this->errorResponse('Transaksi tidak dalam status PENDING.', 400);
        }

        $status = $request->input('status_pembayaran', 'SUCCESS');
        
        // Update status manual
        $transaksi->update([
            'status_pembayaran' => $status
        ]);

        // Jika success, trigger service seperti webhook
        if ($status === 'SUCCESS') {
            try {
                $this->pendanaanService->handlePaymentSuccess($transaksi);
            } catch (\Exception $e) {
                // Return success on verify but indicate error in handling success
                return $this->successResponse(new TransaksiPendanaanResource($transaksi->fresh()), 'Status diverifikasi namun terdapat error pada sistem pembagian dana: ' . $e->getMessage());
            }
        }

        return $this->successResponse(new TransaksiPendanaanResource($transaksi->fresh()), 'Berhasil memverifikasi pendanaan/investor');
    }
}
