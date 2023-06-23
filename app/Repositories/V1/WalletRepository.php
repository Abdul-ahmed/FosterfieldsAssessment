<?php

namespace App\Repositories\V1;

use Illuminate\Http\Request;

interface WalletRepository
{
    public function createDefaultWallet($userId, $defaultWalletTypeId);

    public function walletsByUserId($userId);

}
