<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgramInvestasiResource extends JsonResource
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
            'user_id' => $this->user_id, // Ref KTH
            'gambar' => $this->gambar,
            'nama_kth' => $this->nama_kth,
            'nama_program' => $this->nama_program,
            'kategori_usaha' => $this->kategori_usaha,
            'target_dana' => (float) $this->target_dana,
            'dana_terkumpul' => (float) $this->dana_terkumpul,
            'persentase_terkumpul' => $this->target_dana > 0 ? round(($this->dana_terkumpul / $this->target_dana) * 100, 2) : 0,
            'persentase_keuntungan' => (float) $this->persentase_keuntungan,
            'periode_kontrak_bulan' => $this->periode_kontrak_bulan,
            'batas_waktu_pengumpulan' => $this->batas_waktu_pengumpulan,
            'deskripsi' => $this->deskripsi,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'jumlah_investor' => $this->when(isset($this->jumlah_investor), $this->jumlah_investor, 0),
            
            // Relations
            'milestones' => $this->whenLoaded('milestones'),
            'dokumens' => $this->whenLoaded('dokumens'),
        ];
    }
}
