<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LaporanProyek extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'program_id',
        'milestone_id',
        'deskripsi_kemajuan',
        'dana_terpakai',
        'sisa_dana',
        'status_verifikasi',
        'verified_by_staff_id',
        'catatan_verifikasi',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(ProgramInvestasi::class, 'program_id');
    }

    public function milestone(): BelongsTo
    {
        return $this->belongsTo(ProgramMilestone::class, 'milestone_id');
    }

    public function dokumens(): HasMany
    {
        return $this->hasMany(LaporanProyekDokumen::class, 'laporan_proyek_id');
    }
}
