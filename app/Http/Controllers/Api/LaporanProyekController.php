<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLaporanProyekRequest;
use App\Http\Requests\VerifyLaporanProyekRequest;
use App\Http\Resources\LaporanProyekResource;
use App\Models\LaporanProyek;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiResponse;

class LaporanProyekController extends Controller
{
    use ApiResponse;

    public function store(StoreLaporanProyekRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            
            $laporan = DB::transaction(function () use ($data, $request) {
                $lap = LaporanProyek::create([
                    'program_id' => $data['program_id'],
                    'milestone_id' => $data['milestone_id'] ?? null,
                    'deskripsi_kemajuan' => $data['deskripsi_kemajuan'],
                ]);
                
                if (!empty($data['dokumens'])) {
                    $lap->dokumens()->createMany($data['dokumens']);
                }
                
                return $lap->load('dokumens');
            });
            
            return $this->successResponse(new LaporanProyekResource($laporan), 'Laporan progres berhasil dikirim.', 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function verify(VerifyLaporanProyekRequest $request, string $id): JsonResponse
    {
        $laporan = LaporanProyek::findOrFail($id);
        
        $laporan->update([
            'status_verifikasi' => $request->status_verifikasi,
            'verified_by_staff_id' => $request->user_id, // Dari middleware
            'catatan_verifikasi' => $request->catatan_verifikasi
        ]);

        return $this->successResponse(new LaporanProyekResource($laporan->load('dokumens')), 'Laporan progres berhasil diverifikasi.');
    }
}
