<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramDokumen extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'program_id',
        'tipe_dokumen',
        'file_url',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(ProgramInvestasi::class, 'program_id');
    }
}
