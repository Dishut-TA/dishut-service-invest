<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiPendanaan extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'investor_id',
        'nama',
        'email',
        'no_telp',
        'program_id',
        'nominal_pendanaan',
        'persentase_kepemilikan',
        'status_pembayaran',
        'metode_pembayaran',
        'bukti_transfer_url',
        'dokumen_url',
        'tanggal_bayar',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(ProgramInvestasi::class, 'program_id');
    }
}
