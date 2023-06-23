<?php

namespace App\Repositories\V1;

use Illuminate\Http\Request;

interface WalletTypeRepository
{
    public function walletTypes();

    public function defaultWallet();
}
