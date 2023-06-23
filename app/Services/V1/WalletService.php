<?php

namespace App\Services\V1;

use App\Models\Wallet;
use App\Repositories\V1\WalletRepository;

class WalletService implements WalletRepository
{
    public function createDefaultWallet($userId, $defaultWalletTypeId)
    {
        return Wallet::create([
            'user_id' => $userId,
            'wallet_type_id' => $defaultWalletTypeId
        ]);
    }

    public function walletsByUserId($userId)
    {
        return Wallet::where(['user_id' => $userId])->get();
    }
}
