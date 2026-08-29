<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramInvestasi;
use App\Models\TransaksiPendanaan;
use App\Models\InvestorDividenWallet;

class PendanaanSeeder extends Seeder
{
    public function run(): void
    {
        $program = ProgramInvestasi::first();
        $investorId = '22222222-2222-2222-2222-222222222222'; // Dummy Investor ID
        
        if ($program) {
            TransaksiPendanaan::create([
                'program_id' => $program->id,
                'investor_id' => $investorId,
                'nama' => 'Budi Investor Dummy',
                'email' => 'budi@investor.com',
                'no_telp' => '081234567890',
                'dokumen_url' => 'https://example.com/bukti-transfer.pdf',
                'nominal_pendanaan' => 50000000, // Menyesuaikan dana_terkumpul di program
                'persentase_kepemilikan' => 50, // 50 juta dari 100 juta
                'metode_pembayaran' => 'BANK_TRANSFER',
                'status_pembayaran' => 'SUCCESS', // Enum di db adalah SUCCESS, bukan PAID
                'tanggal_bayar' => now(),
            ]);

            // Simulasi mutasi wallet KTH
            $kthWallet = \App\Models\KthWallet::firstOrCreate(
                ['user_id' => $program->user_id],
                ['saldo_tersedia' => 0]
            );
            $kthWallet->increment('saldo_tersedia', 50000000);
            $kthWallet->mutasis()->create([
                'tipe_mutasi' => 'KREDIT',
                'nominal' => 50000000,
                'metode_pembayaran' => 'BANK_TRANSFER',
                'keterangan' => "Pendanaan masuk untuk program: {$program->nama_program}"
            ]);
        }

        InvestorDividenWallet::create([
            'investor_id' => $investorId,
            'saldo_dividen' => 0, // Akan bertambah saat dividen dibagikan melalui endpoint verify laporan
        ]);
    }
}
