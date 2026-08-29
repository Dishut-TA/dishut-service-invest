<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramInvestasi;
use App\Models\KthWallet;
use Illuminate\Support\Str;

class ProgramInvestasiSeeder extends Seeder
{
    public function run(): void
    {
        $kthId = '11111111-1111-1111-1111-111111111111'; // Dummy KTH ID
        
        $program = ProgramInvestasi::create([
            'user_id' => $kthId,
            'nama_program' => 'Penanaman Kopi Robusta Hutan Lindung',
            'kategori_usaha' => 'Agroforestri',
            'gambar' => 'https://example.com/kopi-robusta.jpg',
            'nama_kth' => 'KTH Maju Bersama',
            'target_dana' => 100000000,
            'dana_terkumpul' => 50000000, // Disimulasikan sudah ada pendanaan masuk
            'persentase_keuntungan' => 20.5,
            'periode_kontrak_bulan' => 36,
            'batas_waktu_pengumpulan' => now()->addMonths(2)->format('Y-m-d'),
            'deskripsi' => 'Program kerjasama KTH dengan petani lokal untuk kopi robusta berkualitas tinggi di area perhutanan sosial.',
            'status' => 'ACTIVE',
            'catatan_verifikasi' => 'Telah disetujui BUPM',
        ]);

        // Seed Milestones
        $program->milestones()->createMany([
            [
                'judul_milestone' => 'Pembersihan Lahan',
                'deskripsi' => 'Pembersihan area 5 Hektar.',
                'target_tanggal' => now()->addMonths(1)->format('Y-m-d'),
                'status' => 'PENDING',
            ],
            [
                'judul_milestone' => 'Penanaman Bibit',
                'deskripsi' => 'Penanaman 10.000 bibit kopi.',
                'target_tanggal' => now()->addMonths(3)->format('Y-m-d'),
                'status' => 'PENDING',
            ]
        ]);

        // Seed Dokumen
        $program->dokumens()->create([
            'tipe_dokumen' => 'PROPOSAL_BISNIS',
            'file_url' => 'https://example.com/proposal.pdf'
        ]);

        // Seed KTH Wallet
        KthWallet::create([
            'user_id' => $kthId,
            'saldo_tersedia' => 0,
        ]);
    }
}
