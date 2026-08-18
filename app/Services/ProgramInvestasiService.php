<?php

namespace App\Services;

use App\Models\ProgramInvestasi;
use Illuminate\Support\Facades\DB;
use Exception;

class ProgramInvestasiService
{
    /**
     * Membuat program investasi beserta relasi milestone dan dokumens
     */
    public function createProgram(array $data, string $userId): ProgramInvestasi
    {
        return DB::transaction(function () use ($data, $userId) {
            // 1. Insert Program
            $program = ProgramInvestasi::create([
                'user_id' => $userId, // Dari token JWT (service-user)
                'nama_program' => $data['nama_program'],
                'kategori_usaha' => $data['kategori_usaha'],
                'target_dana' => $data['target_dana'],
                'persentase_keuntungan' => $data['persentase_keuntungan'],
                'periode_kontrak_bulan' => $data['periode_kontrak_bulan'],
                'batas_waktu_pengumpulan' => $data['batas_waktu_pengumpulan'],
                'deskripsi' => $data['deskripsi'],
                'status' => 'WAITING_STAFF_VERIFICATION', // Default status awal
            ]);

            // 2. Insert Milestones
            if (!empty($data['milestones'])) {
                $program->milestones()->createMany($data['milestones']);
            }

            // 3. Insert Dokumens
            if (!empty($data['dokumens'])) {
                $program->dokumens()->createMany($data['dokumens']);
            }

            return $program->load(['milestones', 'dokumens']);
        });
    }
}
