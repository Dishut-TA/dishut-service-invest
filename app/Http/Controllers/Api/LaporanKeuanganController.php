<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLaporanKeuanganRequest;
use App\Http\Requests\VerifyLaporanKeuanganRequest;
use App\Http\Resources\LaporanKeuanganResource;
use App\Models\LaporanKeuangan;
use App\Services\DividenCalculatorService;
use Illuminate\Http\JsonResponse;
use App\Traits\ApiResponse;

class LaporanKeuanganController extends Controller
{
    use ApiResponse;

    public function __construct(
        private DividenCalculatorService $dividenService
    ) {}

    public function store(StoreLaporanKeuanganRequest $request): JsonResponse
    {
        $data = $request->validated();
        
        // Asumsi backend yang menghitung laba bersih (pendapatan - pengeluaran)
        $sumPendapatan = collect($data['total_pendapatan'])->sum('nominal');
        $sumPengeluaran = collect($data['total_pengeluaran'])->sum('nominal');
        
        $data['laba_bersih'] = $sumPendapatan - $sumPengeluaran;
        
        $laporan = LaporanKeuangan::create($data);
        
        return $this->successResponse(new LaporanKeuanganResource($laporan), 'Laporan keuangan berhasil dikirim.', 201);
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
                return $this->errorResponse('Laporan diverifikasi, namun bagi hasil gagal: ' . $e->getMessage(), 500, new LaporanKeuanganResource($laporan->fresh()));
            }
        }

        $msg = 'Laporan keuangan berhasil diverifikasi' . ($request->status_verifikasi === 'VERIFIED' ? ' dan dividen telah didistribusikan.' : '.');
        return $this->successResponse(new LaporanKeuanganResource($laporan->fresh()), $msg);
    }

    public function cetak(string $id): JsonResponse
    {
        $laporan = LaporanKeuangan::with(['program'])->findOrFail($id);
        
        // Di sini bisa generate PDF atau return data khusus untuk di-print di frontend
        // Mengembalikan data detail laporan agar frontend bisa render PDF/Printable view
        return $this->successResponse(new LaporanKeuanganResource($laporan), 'Data laporan untuk dicetak');
    }
}
