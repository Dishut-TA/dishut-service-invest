<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramMilestone extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'program_id',
        'judul_milestone',
        'deskripsi',
        'target_tanggal',
        'status',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(ProgramInvestasi::class, 'program_id');
    }
}
