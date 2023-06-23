<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletType extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'name',
        'display_name',
        'category',
        'description',
        'minimum_balance',
        'monthly_interest_rate'
    ];

    protected $hidden = [
        'id',
        'name',
        'category',
        'description',
        'minimum_balance',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
