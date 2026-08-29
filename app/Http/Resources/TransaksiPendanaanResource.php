<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransaksiPendanaanResource extends JsonResource
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
            'investor_id' => $this->investor_id,
            'nama' => $this->nama,
            'email' => $this->email,
            'no_telp' => $this->no_telp,
            'dokumen_url' => $this->dokumen_url,
            'program_id' => $this->program_id,
            'nominal_pendanaan' => (float) $this->nominal_pendanaan,
            'persentase_kepemilikan' => (float) $this->persentase_kepemilikan,
            'status_pembayaran' => $this->status_pembayaran,
            'metode_pembayaran' => $this->metode_pembayaran,
            'tanggal_bayar' => $this->tanggal_bayar,
            'program' => new ProgramInvestasiResource($this->whenLoaded('program')),
        ];
    }
}
