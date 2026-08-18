<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgramInvestasi extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'nama_program',
        'kategori_usaha',
        'target_dana',
        'dana_terkumpul',
        'persentase_keuntungan',
        'periode_kontrak_bulan',
        'batas_waktu_pengumpulan',
        'deskripsi',
        'status',
    ];

    public function milestones(): HasMany
    {
        return $this->hasMany(ProgramMilestone::class, 'program_id');
    }

    public function dokumens(): HasMany
    {
        return $this->hasMany(ProgramDokumen::class, 'program_id');
    }

    public function transaksiPendanaans(): HasMany
    {
        return $this->hasMany(TransaksiPendanaan::class, 'program_id');
    }

    public function laporanProyeks(): HasMany
    {
        return $this->hasMany(LaporanProyek::class, 'program_id');
    }

    public function laporanKeuangans(): HasMany
    {
        return $this->hasMany(LaporanKeuangan::class, 'program_id');
    }
}
