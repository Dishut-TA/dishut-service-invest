<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KthWalletMutasi extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'kth_wallet_id',
        'referensi_id',
        'tipe_mutasi',
        'nominal',
        'keterangan',
    ];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(KthWallet::class, 'kth_wallet_id');
    }
}
