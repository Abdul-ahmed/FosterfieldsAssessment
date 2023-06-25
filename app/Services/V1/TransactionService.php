<?php

namespace App\Services\V1;

use App\Models\Transaction;
use App\Repositories\V1\TransactionRepository;

class TransactionService implements TransactionRepository
{
    public function userTransactions($userId)
    {
        return Transaction::where(["user_id" => $userId])->paginate(10);
    }

    public function sendMoney($from, $to, $amount)
    {
        $debit = $this->debit($from, $amount);
        $credit = $this->credit($to, $amount);

        return [
            "debit" => $debit,
            "credit" => $credit
        ];
    }

    public function debit($from, $amount)
    {
        $charges = 0.00;
        $totalAmount = $amount + $charges;
        $balanceAfter = $from->balance - $totalAmount;
        $debit = Transaction::create([
            "reference" => rand(1000000, 9999999),
            "user_id" => $from->user_id,
            "from_wallet_id" => $from->id,
            "currency" => "NGN",
            "amount" => $amount,
            "charges" => $charges,
            "total_amount" => $totalAmount,
            "type" => "debit",
            "balance_before" => $from->balance,
            "balance_after" => $balanceAfter,
            "status" => "success",
        ]);

        $this->updateWallet($from, $balanceAfter);
        return $debit;
    }

    public function updateWallet($wallet, $balanceAfter)
    {
        $wallet->update([
            "balance" => $balanceAfter
        ]);
    }


    public function credit($to, $amount)
    {
        $balanceAfter = $to->balance + $amount;
        $credit = Transaction::create([
            "reference" => rand(1000000, 9999999),
            "user_id" => $to->user_id,
            "from_wallet_id" => $to->id,
            "currency" => "NGN",
            "amount" => $amount,
            "charges" => 0.00,
            "total_amount" => $amount,
            "type" => "credit",
            "balance_before" => $to->balance,
            "balance_after" => $balanceAfter,
            "status" => "success",
        ]);

        $this->updateWallet($to, $balanceAfter);
        return $credit;
    }

}
