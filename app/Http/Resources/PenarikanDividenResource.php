<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PenarikanDividenResource extends JsonResource
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
            'nominal_penarikan' => (float) $this->nominal_penarikan,
            'bank_tujuan' => $this->bank_tujuan,
            'nomor_rekening' => $this->nomor_rekening,
            'nama_pemilik_rekening' => $this->nama_pemilik_rekening,
            'status' => $this->status,
            'bukti_transfer_bupm_url' => $this->bukti_transfer_bupm_url,
            'tanggal_proses' => $this->tanggal_proses,
            'created_at' => $this->created_at,
        ];
    }
}
