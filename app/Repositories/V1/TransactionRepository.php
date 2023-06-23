<?php

namespace App\Repositories\V1;

use Illuminate\Http\Request;

interface TransactionRepository
{
    public function userTransactions($userId);

}
