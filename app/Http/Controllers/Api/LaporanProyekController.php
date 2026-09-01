<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLaporanProyekRequest;
use App\Http\Requests\VerifyLaporanProyekRequest;
use App\Http\Resources\LaporanProyekResource;
use App\Models\LaporanProyek;
use Illuminate\Http\Request;
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
                // Kalkulasi sisa_dana
                $program = \App\Models\ProgramInvestasi::findOrFail($data['program_id']);
                $previousLaporan = \App\Models\LaporanProyek::where('program_id', $data['program_id'])
                    ->orderBy('created_at', 'desc')
                    ->first();
                
                $saldoAwal = $previousLaporan ? $previousLaporan->sisa_dana : $program->dana_terkumpul;
                $sisaDana = $saldoAwal - $data['dana_terpakai'];

                $lap = LaporanProyek::create([
                    'program_id' => $data['program_id'],
                    'milestone_id' => $data['milestone_id'] ?? null,
                    'deskripsi_kemajuan' => $data['deskripsi_kemajuan'],
                    'dana_terpakai' => $data['dana_terpakai'],
                    'sisa_dana' => $sisaDana,
                ]);
                
                if (!empty($data['dokumens'])) {
                    $lap->dokumens()->createMany($data['dokumens']);
                }
                
                return $lap->load(['program', 'milestone', 'dokumens']);
            });
            
            return $this->successResponse(new LaporanProyekResource($laporan), 'Laporan progres berhasil dikirim.', 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function update(StoreLaporanProyekRequest $request, string $id): JsonResponse
    {
        try {
            $data = $request->validated();
            
            $laporan = DB::transaction(function () use ($data, $id) {
                $lap = LaporanProyek::findOrFail($id);
                
                $program = \App\Models\ProgramInvestasi::findOrFail($data['program_id']);
                $previousLaporan = \App\Models\LaporanProyek::where('program_id', $data['program_id'])
                    ->where('created_at', '<', $lap->created_at)
                    ->orderBy('created_at', 'desc')
                    ->first();
                
                $saldoAwal = $previousLaporan ? $previousLaporan->sisa_dana : $program->dana_terkumpul;
                $sisaDana = $saldoAwal - $data['dana_terpakai'];

                $lap->update([
                    'program_id' => $data['program_id'],
                    'milestone_id' => $data['milestone_id'] ?? null,
                    'deskripsi_kemajuan' => $data['deskripsi_kemajuan'],
                    'dana_terpakai' => $data['dana_terpakai'],
                    'sisa_dana' => $sisaDana,
                    'status_verifikasi' => 'PENDING',
                ]);
                
                if (!empty($data['dokumens'])) {
                    $lap->dokumens()->delete();
                    $lap->dokumens()->createMany($data['dokumens']);
                }
                
                return $lap->load(['program', 'milestone', 'dokumens']);
            });
            
            return $this->successResponse(new LaporanProyekResource($laporan), 'Laporan progres berhasil diperbarui.');
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

        return $this->successResponse(new LaporanProyekResource($laporan->load(['program', 'milestone', 'dokumens'])), 'Laporan progres berhasil diverifikasi.');
    }

    public function indexAdmin(Request $request): JsonResponse
    {
        $query = LaporanProyek::with(['program', 'milestone', 'dokumens']);
        
        $laporan = $query->paginate(10);
        return $this->successResponse(LaporanProyekResource::collection($laporan)->response()->getData(true), 'Berhasil mengambil daftar laporan proyek untuk admin');
    }

    public function showAdmin(string $id): JsonResponse
    {
        $laporan = LaporanProyek::with(['program', 'milestone', 'dokumens'])->findOrFail($id);
        return $this->successResponse(new LaporanProyekResource($laporan), 'Berhasil mengambil detail laporan proyek admin');
    }
}
