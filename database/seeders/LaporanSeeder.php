<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramInvestasi;
use App\Models\LaporanProyek;
use App\Models\LaporanKeuangan;

class LaporanSeeder extends Seeder
{
    public function run(): void
    {
        $program = ProgramInvestasi::first();
        $staffId = '33333333-3333-3333-3333-333333333333'; // Dummy BUPM Staff ID

        if ($program) {
            // Laporan Proyek
            $lapProyek = LaporanProyek::create([
                'program_id' => $program->id,
                'milestone_id' => $program->milestones()->first()->id ?? null,
                'deskripsi_kemajuan' => 'Lahan telah berhasil dibersihkan dan siap ditanam.',
                'status_verifikasi' => 'VERIFIED',
                'verified_by_staff_id' => $staffId,
                'catatan_verifikasi' => 'Sesuai dengan laporan foto.',
            ]);

            $lapProyek->dokumens()->create([
                'file_url' => 'https://example.com/foto-lapangan.jpg',
            ]);

            // Laporan Keuangan
            LaporanKeuangan::create([
                'program_id' => $program->id,
                'periode_awal' => now()->subMonth()->startOfMonth()->format('Y-m-d'),
                'periode_akhir' => now()->subMonth()->endOfMonth()->format('Y-m-d'),
                'total_pendapatan' => 10000000,
                'total_pengeluaran' => 2000000,
                'laba_bersih' => 8000000,
                'bukti_nota_url' => 'https://example.com/nota-keuangan.pdf',
                'status_verifikasi' => 'PENDING', // Sengaja pending agar user bisa men-test verify laporan & trigger otomatis dividen
            ]);
        }
    }
}
