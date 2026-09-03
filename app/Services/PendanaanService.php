<?php

namespace App\Services;

use App\Models\ProgramInvestasi;
use App\Models\TransaksiPendanaan;
use App\Models\KthWallet;
use Illuminate\Support\Facades\DB;
use Exception;

class PendanaanService
{
    /**
     * Memulai transaksi pendanaan
     */
    public function initializePayment(array $data, string $investorId): TransaksiPendanaan
    {
        $program = ProgramInvestasi::findOrFail($data['program_id']);
        
        // Validasi: Apakah program masih aktif
        if ($program->status !== 'ACTIVE') {
            throw new Exception("Program investasi belum/tidak aktif.");
        }

        // Validasi: Apakah target dana terlampaui
        $sisaTarget = $program->target_dana - $program->dana_terkumpul;
        if ($data['nominal_pendanaan'] > $sisaTarget) {
            throw new Exception("Nominal pendanaan melebihi sisa target dana program (Sisa: $sisaTarget).");
        }

        // Hitung persentase kepemilikan sementara
        $persentase = ($data['nominal_pendanaan'] / $program->target_dana) * 100;

        // Buat record PENDING
        return TransaksiPendanaan::create([
            'investor_id' => $investorId,
            'nama' => $data['nama'] ?? null,
            'email' => $data['email'] ?? null,
            'no_telp' => $data['no_telp'] ?? null,
            'dokumen_url' => $data['dokumen_url'] ?? null,
            'program_id' => $program->id,
            'nominal_pendanaan' => $data['nominal_pendanaan'],
            'persentase_kepemilikan' => $persentase,
            'status_pembayaran' => 'PENDING',
            'status_persetujuan' => 'MENUNGGU',
            'metode_pembayaran' => $data['metode_pembayaran'],
        ]);
    }

    /**
     * Webhook/Callback handling ketika pembayaran sukses
     */
    public function handlePaymentSuccess(TransaksiPendanaan $transaksi): void
    {
        if ($transaksi->status_pembayaran === 'SUCCESS') return; // Idempotency check

        DB::transaction(function () use ($transaksi) {
            // 1. Update status transaksi
            $transaksi->update([
                'status_pembayaran' => 'SUCCESS',
                'tanggal_bayar' => now()
            ]);

            // 2. Tambahkan dana terkumpul ke Program
            $program = $transaksi->program;
            $program->increment('dana_terkumpul', $transaksi->nominal_pendanaan);

            // Jika dana_terkumpul >= target_dana, otomatis ubah status ke FUNDED
            if ($program->dana_terkumpul >= $program->target_dana) {
                $program->update(['status' => 'FUNDED']);
            }

            // 3. Tambahkan ke KthWallet (Saldo Operasional KTH)
            $wallet = KthWallet::firstOrCreate(
                ['user_id' => $program->user_id], // user_id (KTH)
                ['saldo_tersedia' => 0]
            );

            $wallet->increment('saldo_tersedia', $transaksi->nominal_pendanaan);

            // 4. Catat Mutasi E-Wallet
            $wallet->mutasis()->create([
                'tipe_mutasi' => 'KREDIT',
                'nominal' => $transaksi->nominal_pendanaan,
                'keterangan' => "Pendanaan masuk untuk program: {$program->nama_program}"
            ]);
        });
    }
}
