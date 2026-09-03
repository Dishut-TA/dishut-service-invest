<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransaksiPendanaanResource;
use App\Services\PersetujuanInvestorService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Traits\ApiResponse;

class PersetujuanInvestorController extends Controller
{
    use ApiResponse;

    public function __construct(
        private PersetujuanInvestorService $persetujuanService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $kthId = $request->user_id; // From middleware / token
        $filters = $request->only(['status_persetujuan', 'per_page']);
        
        $pengajuans = $this->persetujuanService->getListPengajuan($kthId, $filters);
        
        return $this->successResponse(
            TransaksiPendanaanResource::collection($pengajuans)->response()->getData(true),
            'Berhasil mengambil daftar pengajuan investasi.'
        );
    }

    public function show(Request $request, string $id): JsonResponse
    {
        try {
            $kthId = $request->user_id;
            $pengajuan = $this->persetujuanService->getDetailPengajuan($id, $kthId);
            
            return $this->successResponse(
                new TransaksiPendanaanResource($pengajuan),
                'Berhasil mengambil detail pengajuan investasi.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    public function updateStatus(Request $request, string $id): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:DITERIMA,DITOLAK,MENUNGGU_REVISI'
        ]);

        try {
            $kthId = $request->user_id;
            $pengajuan = $this->persetujuanService->updateStatus($id, $request->status, $kthId);
            
            return $this->successResponse(
                new TransaksiPendanaanResource($pengajuan),
                "Berhasil memperbarui status persetujuan menjadi {$request->status}."
            );
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }
}
