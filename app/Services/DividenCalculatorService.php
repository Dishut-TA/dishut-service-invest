<?php

namespace App\Services;

use App\Models\LaporanKeuangan;
use App\Models\ProgramInvestasi;
use App\Models\PembagianDividen;
use App\Models\KthWallet;
use App\Models\InvestorDividenWallet;
use Illuminate\Support\Facades\DB;
use Exception;

class DividenCalculatorService
{
    /**
     * Mendistribusikan dividen berdasarkan persentase 60:40 ketika Laporan Keuangan di-Approve
     */
    public function distributeDividends(LaporanKeuangan $laporan): void
    {
        if ($laporan->status_verifikasi !== 'VERIFIED') {
            throw new Exception("Laporan belum diverifikasi BUPM.");
        }
        
        if ($laporan->is_dividends_distributed) {
            throw new Exception("Dividen sudah didistribusikan untuk laporan ini.");
        }

        if ($laporan->laba_bersih <= 0) {
            throw new Exception("Tidak ada laba bersih untuk dibagikan.");
        }

        $program = $laporan->program;

        DB::transaction(function () use ($laporan, $program) {
            // 1. Kalkulasi Porsi 60:40
            $porsiKth = $laporan->laba_bersih * 0.60;
            $porsiInvestor = $laporan->laba_bersih * 0.40;

            // 2. Buat Rekap Pembagian Dividen
            $pembagian = PembagianDividen::create([
                'laporan_keuangan_id' => $laporan->id,
                'program_id' => $program->id,
                'total_laba_bersih' => $laporan->laba_bersih,
                'porsi_kth' => $porsiKth,
                'porsi_investor' => $porsiInvestor,
                'status_distribusi' => 'DISTRIBUTED',
                'tanggal_distribusi' => now(),
            ]);

            // 3. Distribusikan ke KthWallet (Porsi 60%)
            $kthWallet = KthWallet::firstOrCreate(
                ['user_id' => $program->user_id],
                ['saldo_tersedia' => 0]
            );
            $kthWallet->increment('saldo_tersedia', $porsiKth);
            $kthWallet->mutasis()->create([
                'tipe_mutasi' => 'KREDIT',
                'nominal' => $porsiKth,
                'keterangan' => "Bagi hasil 60% dari Laba Bersih Program: {$program->nama_program}"
            ]);

            // 4. Distribusikan ke Seluruh Investor (Porsi 40%) secara proporsional
            $transaksis = $program->transaksiPendanaans()->where('status_pembayaran', 'SUCCESS')->get();
            
            foreach ($transaksis as $trx) {
                // Kalkulasi nominal yang didapat investor ini: (Kepemilikan / 100) * Porsi 40%
                $dividenInvestorIni = ($trx->persentase_kepemilikan / 100) * $porsiInvestor;
                
                if ($dividenInvestorIni > 0) {
                    $investorWallet = InvestorDividenWallet::firstOrCreate(
                        ['investor_id' => $trx->investor_id],
                        ['saldo_dividen' => 0]
                    );
                    
                    $investorWallet->increment('saldo_dividen', $dividenInvestorIni);
                    
                    $investorWallet->mutasis()->create([
                        'referensi_id' => $pembagian->id,
                        'tipe_mutasi' => 'KREDIT',
                        'nominal' => $dividenInvestorIni,
                        'keterangan' => "Bagi hasil dividen dari Program: {$program->nama_program}"
                    ]);
                }
            }

            // 5. Tandai Laporan sudah didistribusikan
            $laporan->update(['is_dividends_distributed' => true]);
        });
    }
}
