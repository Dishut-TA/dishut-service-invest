<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LaporanProyekResource extends JsonResource
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
            'milestone_id' => $this->milestone_id,
            'program' => $this->whenLoaded('program'),
            'milestone' => $this->whenLoaded('milestone'),
            'deskripsi_kemajuan' => $this->deskripsi_kemajuan,
            'dana_terpakai' => $this->dana_terpakai,
            'sisa_dana' => $this->sisa_dana,
            'status_verifikasi' => $this->status_verifikasi,
            'catatan_verifikasi' => $this->catatan_verifikasi,
            'created_at' => $this->created_at,
            'dokumens' => $this->whenLoaded('dokumens'),
        ];
    }
}
