<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KthWallet extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'saldo_tersedia',
    ];

    public function mutasis(): HasMany
    {
        return $this->hasMany(KthWalletMutasi::class, 'kth_wallet_id');
    }
}
