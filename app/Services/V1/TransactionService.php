<?php

namespace App\Services\V1;

use App\Models\Transaction;
use App\Repositories\V1\TransactionRepository;

class TransactionService implements TransactionRepository
{
    public function userTransactions($userId)
    {
        return Transaction::where(["user_id" => $userId])->get();
    }

}
