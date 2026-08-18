<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePenarikanRequest;
use App\Http\Requests\ProcessPenarikanRequest;
use App\Http\Resources\PenarikanDividenResource;
use App\Models\PenarikanDividen;
use App\Services\PenarikanService;
use Illuminate\Http\JsonResponse;
use App\Traits\ApiResponse;

class PenarikanDividenController extends Controller
{
    use ApiResponse;

    public function __construct(
        private PenarikanService $penarikanService
    ) {}

    public function store(StorePenarikanRequest $request): JsonResponse
    {
        try {
            $investorId = $request->user_id; // Dari middleware / token
            $penarikan = $this->penarikanService->requestWithdrawal($request->validated(), $investorId);
            
            return $this->successResponse(new PenarikanDividenResource($penarikan), 'Permintaan penarikan dividen berhasil dibuat.', 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    public function process(ProcessPenarikanRequest $request, string $id): JsonResponse
    {
        $penarikan = PenarikanDividen::findOrFail($id);
        
        $penarikan->update([
            'status' => $request->status,
            'bukti_transfer_bupm_url' => $request->bukti_transfer_bupm_url,
            'tanggal_proses' => now(),
        ]);

        return $this->successResponse(new PenarikanDividenResource($penarikan), 'Status penarikan dividen berhasil diupdate.');
    }
}
