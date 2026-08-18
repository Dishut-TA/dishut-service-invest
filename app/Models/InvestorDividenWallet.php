<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestorDividenWallet extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'investor_id',
        'saldo_dividen',
    ];
}
