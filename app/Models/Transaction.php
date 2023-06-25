<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        "reference",
        "user_id",
        "from_wallet_id",
        "currency",
        "amount",
        "charges",
        "total_amount",
        "type",
        "balance_before",
        "balance_after",
        "status",
    ];

    protected $hidden = [
        'id',
        'user_id',
        'from_wallet_id',
    ];

}
