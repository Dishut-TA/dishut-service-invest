<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InvestorDividenWallet extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'investor_id',
        'saldo_dividen',
    ];

    public function pembagianDividens(): HasMany
    {
        return $this->hasMany(PembagianDividen::class, 'investor_id', 'investor_id');
    }

    public function mutasis(): HasMany
    {
        return $this->hasMany(InvestorWalletMutasi::class, 'investor_wallet_id');
    }
}
