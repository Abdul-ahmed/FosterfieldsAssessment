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

    public function wallets()
    {
        return Wallet::paginate(10);
    }

    public function wallet($walletUuid)
    {
        return Wallet::where(['uuid' => $walletUuid])->first();
    }

    public function walletExistByUser($walletTypeId, $userId)
    {
        return Wallet::where([
            'user_id' => $userId,
            'wallet_type_id' => $walletTypeId
        ])->first();
    }

    public function createWallet($walletTypeId, $userId)
    {
        return Wallet::create([
            'user_id' => $userId,
            'wallet_type_id' => $walletTypeId
        ]);
    }

    public function walletByUser($walletUuid, $userId)
    {
        return Wallet::where([
            'user_id' => $userId,
            'uuid' => $walletUuid
        ])->first();
    }
}
