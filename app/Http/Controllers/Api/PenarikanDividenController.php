<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePenarikanRequest;
use App\Http\Requests\ProcessPenarikanRequest;
use App\Http\Resources\PenarikanDividenResource;
use App\Models\PenarikanDividen;
use App\Services\PenarikanService;
use Illuminate\Http\JsonResponse;

class PenarikanDividenController extends Controller
{
    public function __construct(
        private PenarikanService $penarikanService
    ) {}

    public function store(StorePenarikanRequest $request): JsonResponse
    {
        try {
            $investorId = $request->user_id; // Dari middleware / token
            $penarikan = $this->penarikanService->requestWithdrawal($request->validated(), $investorId);
            
            return response()->json([
                'message' => 'Permintaan penarikan dividen berhasil dibuat.',
                'data' => new PenarikanDividenResource($penarikan)
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
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

        return response()->json([
            'message' => 'Status penarikan dividen berhasil diupdate.',
            'data' => new PenarikanDividenResource($penarikan)
        ]);
    }
}
