<?php

namespace App\Repositories\V1;

use Illuminate\Http\Request;

interface TransactionRepository
{
    public function userTransactions($userId);

    public function sendMoney($from, $to, $amount);

    public function debit($from, $amount);

    public function updateWallet($wallet, $balanceAfter);

    public function credit($to, $amount);

}
