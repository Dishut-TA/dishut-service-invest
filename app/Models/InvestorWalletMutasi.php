<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvestorWalletMutasi extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'investor_wallet_id',
        'referensi_id',
        'tipe_mutasi',
        'nominal',
        'metode_pembayaran',
        'keterangan',
    ];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(InvestorDividenWallet::class, 'investor_wallet_id');
    }
}
