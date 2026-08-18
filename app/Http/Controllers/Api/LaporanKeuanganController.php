<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLaporanKeuanganRequest;
use App\Http\Requests\VerifyLaporanKeuanganRequest;
use App\Http\Resources\LaporanKeuanganResource;
use App\Models\LaporanKeuangan;
use App\Services\DividenCalculatorService;
use Illuminate\Http\JsonResponse;

class LaporanKeuanganController extends Controller
{
    public function __construct(
        private DividenCalculatorService $dividenService
    ) {}

    public function store(StoreLaporanKeuanganRequest $request): JsonResponse
    {
        $data = $request->validated();
        
        // Asumsi backend yang menghitung laba bersih (pendapatan - pengeluaran)
        $data['laba_bersih'] = $data['total_pendapatan'] - $data['total_pengeluaran'];
        
        $laporan = LaporanKeuangan::create($data);
        
        return response()->json([
            'message' => 'Laporan keuangan berhasil dikirim.',
            'data' => new LaporanKeuanganResource($laporan)
        ], 201);
    }

    public function verify(VerifyLaporanKeuanganRequest $request, string $id): JsonResponse
    {
        $laporan = LaporanKeuangan::with(['program'])->findOrFail($id);
        
        $laporan->update([
            'status_verifikasi' => $request->status_verifikasi,
            'verified_by_staff_id' => $request->user_id, // Dari middleware
            'catatan_verifikasi' => $request->catatan_verifikasi
        ]);

        // Jika disetujui, otomatis picu bagi hasil dividen
        if ($request->status_verifikasi === 'VERIFIED') {
            try {
                $this->dividenService->distributeDividends($laporan);
            } catch (\Exception $e) {
                // Log error jika pembagian dividen gagal, tapi laporan tetap verified
                \Illuminate\Support\Facades\Log::error('Dividen gagal dibagikan: ' . $e->getMessage());
                return response()->json([
                    'message' => 'Laporan diverifikasi, namun bagi hasil gagal: ' . $e->getMessage(),
                    'data' => new LaporanKeuanganResource($laporan->fresh())
                ], 500);
            }
        }

        return response()->json([
            'message' => 'Laporan keuangan berhasil diverifikasi' . ($request->status_verifikasi === 'VERIFIED' ? ' dan dividen telah didistribusikan.' : '.'),
            'data' => new LaporanKeuanganResource($laporan->fresh())
        ]);
    }
}
