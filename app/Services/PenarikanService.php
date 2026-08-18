<?php

namespace App\Services;

use App\Models\PenarikanDividen;
use App\Models\InvestorDividenWallet;
use Illuminate\Support\Facades\DB;
use Exception;

class PenarikanService
{
    /**
     * Investor me-request penarikan dana
     */
    public function requestWithdrawal(array $data, string $investorId): PenarikanDividen
    {
        return DB::transaction(function () use ($data, $investorId) {
            $wallet = InvestorDividenWallet::where('investor_id', $investorId)->first();

            if (!$wallet || $wallet->saldo_dividen < $data['nominal_penarikan']) {
                throw new Exception("Saldo dividen tidak mencukupi untuk melakukan penarikan.");
            }

            // Potong saldo investor
            $wallet->decrement('saldo_dividen', $data['nominal_penarikan']);

            // Buat record penarikan dengan status PENDING
            return PenarikanDividen::create([
                'investor_id' => $investorId,
                'nominal_penarikan' => $data['nominal_penarikan'],
                'bank_tujuan' => $data['bank_tujuan'],
                'nomor_rekening' => $data['nomor_rekening'],
                'nama_pemilik_rekening' => $data['nama_pemilik_rekening'],
                'status' => 'PENDING',
            ]);
        });
    }
}
