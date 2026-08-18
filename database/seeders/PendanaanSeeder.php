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
                'nominal_pendanaan' => 50000000, // Menyesuaikan dana_terkumpul di program
                'persentase_kepemilikan' => 50, // 50 juta dari 100 juta
                'metode_pembayaran' => 'BANK_TRANSFER',
                'status_pembayaran' => 'SUCCESS', // Enum di db adalah SUCCESS, bukan PAID
                'tanggal_bayar' => now(),
            ]);
        }

        InvestorDividenWallet::create([
            'investor_id' => $investorId,
            'saldo_dividen' => 0, // Akan bertambah saat dividen dibagikan melalui endpoint verify laporan
        ]);
    }
}
