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
            'status_persetujuan' => $this->status_persetujuan,
            'metode_pembayaran' => $this->metode_pembayaran,
            'tanggal_bayar' => $this->tanggal_bayar,
            'program' => new ProgramInvestasiResource($this->whenLoaded('program')),
            'riwayat_keuntungan' => $this->getRiwayatKeuntungan(),
        ];
    }

    private function getRiwayatKeuntungan(): array
    {
        // Only return if program is loaded or exists
        if (!$this->program_id) return [];

        // Query directly to get PembagianDividen for this program
        $pembagians = \App\Models\PembagianDividen::with(['laporanKeuangan'])
            ->where('program_id', $this->program_id)
            ->orderBy('created_at', 'asc')
            ->get();

        $riwayat = [];
        foreach ($pembagians as $pembagian) {
            $nominal = ($this->persentase_kepemilikan / 100) * $pembagian->porsi_investor;
            
            // Format periode dari tanggal distribusi atau laporan keuangan
            $tanggal = $pembagian->tanggal_distribusi 
                ? \Carbon\Carbon::parse($pembagian->tanggal_distribusi)
                : $pembagian->created_at;
                
            $riwayat[] = [
                'id' => $pembagian->id,
                'periode' => 'Bulan ' . $tanggal->translatedFormat('F Y'),
                'nominal' => $nominal,
                'status' => $pembagian->status_distribusi === 'DISTRIBUTED' ? 'Berhasil' : 'Menunggu'
            ];
        }

        return $riwayat;
    }
}
