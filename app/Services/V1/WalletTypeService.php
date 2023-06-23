<?php

namespace App\Services\V1;

use App\Models\WalletType;
use App\Repositories\V1\WalletTypeRepository;

class WalletTypeService implements WalletTypeRepository
{
    public function walletTypes()
    {
        return WalletType::get();
    }

    public function defaultWallet()
    {
        return WalletType::first();
    }

}
