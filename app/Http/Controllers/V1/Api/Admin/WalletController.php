<?php

namespace App\Http\Controllers\V1\Api\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\V1\WalletRepository;
use App\Traits\ControllersTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WalletController extends Controller
{
    use ControllersTrait;

    private $walletRepository;

    public function __construct(
        WalletRepository $walletRepository,
    ){
        $this->walletRepository = $walletRepository;
    }

    public function getWallets()
    {
        $wallets = $this->walletRepository->wallets();
        return $this->successResponse("Record fetch successfully", $wallets, Response::HTTP_OK);

    }

    public function getWallet($walletUuid)
    {
        $wallet = $this->walletRepository->wallet($walletUuid);
        if (!$wallet) {
            return $this->failureResponse("Wallet not found", null, Response::HTTP_BAD_REQUEST);
        }

        $wallet = $this->formatGetWallets($wallet);
        return $this->successResponse("Record fetch successfully", $wallet, Response::HTTP_OK);
    }

    public function formatGetWallets($wallet)
    {
        return [
            'uuid' => $wallet->uuid,
            'first_name' => $wallet->user->first_name,
            'middle_name' => $wallet->user->middle_name,
            'last_name' => $wallet->user->last_name,
            'wallet_type' => $wallet->walletType->display_name,
            'minimum_balance' => $wallet->walletType->minimum_balance,
            'monthly_interest_rate' => $wallet->walletType->monthly_interest_rate,
            'balance' => $wallet->balance,
            'status' => $wallet->status,
            'created_at' => $wallet->created_at,
            'updated_at' => $wallet->updated_at,
            'deleted_at' => $wallet->deleted_at,
        ];
    }
}
