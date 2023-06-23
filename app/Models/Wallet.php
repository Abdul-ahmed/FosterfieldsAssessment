<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'user_id',
        'wallet_type_id',
        'balance',
        'status'
    ];

    public function walletType()
    {
        return $this->hasOne(WalletType::class, 'id', 'wallet_type_id');
    }

}
