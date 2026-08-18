<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LaporanKeuanganResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'program_id' => $this->program_id,
            'periode_awal' => $this->periode_awal,
            'periode_akhir' => $this->periode_akhir,
            'total_pendapatan' => (float) $this->total_pendapatan,
            'total_pengeluaran' => (float) $this->total_pengeluaran,
            'laba_bersih' => (float) $this->laba_bersih,
            'bukti_nota_url' => $this->bukti_nota_url,
            'status_verifikasi' => $this->status_verifikasi,
            'catatan_verifikasi' => $this->catatan_verifikasi,
            'is_dividends_distributed' => (bool) $this->is_dividends_distributed,
            'created_at' => $this->created_at,
        ];
    }
}
