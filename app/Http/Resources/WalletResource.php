<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
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
            'user_id' => $this->user_id ?? $this->investor_id, // Support KthWallet atau InvestorDividenWallet
            'saldo' => (float) ($this->saldo_tersedia ?? $this->saldo_dividen),
            'updated_at' => $this->updated_at,
            'mutasi' => MutasiWalletResource::collection($this->whenLoaded('mutasis')),
        ];
    }
}
