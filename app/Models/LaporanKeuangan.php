<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LaporanKeuangan extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'program_id',
        'periode_awal',
        'periode_akhir',
        'total_pendapatan',
        'total_pengeluaran',
        'laba_bersih',
        'bukti_nota_url',
        'status_verifikasi',
        'verified_by_staff_id',
        'catatan_verifikasi',
        'is_dividends_distributed',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(ProgramInvestasi::class, 'program_id');
    }

    public function pembagianDividens(): HasMany
    {
        return $this->hasMany(PembagianDividen::class, 'laporan_keuangan_id');
    }
}
