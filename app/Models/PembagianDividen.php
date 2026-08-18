<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PembagianDividen extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'laporan_keuangan_id',
        'program_id',
        'total_laba_bersih',
        'porsi_kth',
        'porsi_investor',
        'status_distribusi',
        'tanggal_distribusi',
    ];

    public function laporanKeuangan(): BelongsTo
    {
        return $this->belongsTo(LaporanKeuangan::class, 'laporan_keuangan_id');
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(ProgramInvestasi::class, 'program_id');
    }
}
