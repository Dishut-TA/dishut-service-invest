<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenarikanDividen extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'investor_id',
        'nominal_penarikan',
        'bank_tujuan',
        'nomor_rekening',
        'nama_pemilik_rekening',
        'status',
        'bukti_transfer_bupm_url',
        'tanggal_proses',
    ];
}
