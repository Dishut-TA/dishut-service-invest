<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanProyekDokumen extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'laporan_proyek_id',
        'file_url',
    ];

    public function laporanProyek(): BelongsTo
    {
        return $this->belongsTo(LaporanProyek::class, 'laporan_proyek_id');
    }
}
