<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyProgramRequest;
use App\Http\Resources\ProgramInvestasiResource;
use App\Models\ProgramInvestasi;
use Illuminate\Http\JsonResponse;

class VerifikasiProgramController extends Controller
{
    public function verify(VerifyProgramRequest $request, string $id): JsonResponse
    {
        $program = ProgramInvestasi::findOrFail($id);
        
        $program->update([
            'status' => $request->status,
            'catatan_verifikasi' => $request->catatan_verifikasi
        ]);

        return response()->json([
            'message' => 'Status program investasi berhasil diupdate.',
            'data' => new ProgramInvestasiResource($program)
        ]);
    }
}
