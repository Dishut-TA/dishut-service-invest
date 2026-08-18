<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyProgramRequest;
use App\Http\Resources\ProgramInvestasiResource;
use App\Models\ProgramInvestasi;
use Illuminate\Http\JsonResponse;
use App\Traits\ApiResponse;

class VerifikasiProgramController extends Controller
{
    use ApiResponse;

    public function verify(VerifyProgramRequest $request, string $id): JsonResponse
    {
        $program = ProgramInvestasi::findOrFail($id);
        
        $program->update([
            'status' => $request->status,
            'catatan_verifikasi' => $request->catatan_verifikasi
        ]);

        return $this->successResponse(new ProgramInvestasiResource($program), 'Status program investasi berhasil diupdate.');
    }
}
