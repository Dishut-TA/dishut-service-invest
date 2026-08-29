<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PenarikanDividen;
use App\Models\InvestorDividenWallet;

class PenarikanDividenSeeder extends Seeder
{
    public function run(): void
    {
        $wallet = InvestorDividenWallet::first();
        
        if ($wallet) {
            // Beri saldo dummy dulu untuk disimulasikan ditarik
            $wallet->update(['saldo_dividen' => 500000]);

            PenarikanDividen::create([
                'investor_id' => $wallet->investor_id,
                'nominal_penarikan' => 100000,
                'bank_tujuan' => 'BCA',
                'nomor_rekening' => '1234567890',
                'nama_pemilik_rekening' => 'Budi Investor Dummy',
                'status' => 'PENDING',
            ]);

            // Potong saldo sesuai penarikan
            $wallet->decrement('saldo_dividen', 100000);

            // Simulasikan Mutasi Wallet Investor
            \App\Models\InvestorWalletMutasi::create([
                'investor_wallet_id' => $wallet->id,
                'tipe_mutasi' => 'DEBIT',
                'nominal' => 100000,
                'keterangan' => 'Penarikan dividen ke rekening BCA',
            ]);
        }
    }
}
