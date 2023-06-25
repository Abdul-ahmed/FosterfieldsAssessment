<?php

namespace App\Repositories\V1;

use Illuminate\Http\Request;

interface WalletRepository
{
    public function createDefaultWallet($userId, $defaultWalletTypeId);

    public function walletsByUserId($userId);

    public function wallets();

    public function wallet($walletUuid);

    public function walletExistByUser($walletTypeId, $userId);

    public function createWallet($walletTypeId, $userId);

    public function walletByUser($walletUuid, $userId);
}
