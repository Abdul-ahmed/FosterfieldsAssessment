<?php

namespace App\Http\Controllers\V1\Api\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\V1\TransactionRepository;
use App\Repositories\V1\UserRepository;
use App\Repositories\V1\WalletRepository;
use App\Traits\ControllersTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    use ControllersTrait;

    private $userRepository;
    private $walletRepository;
    private $transactionRepository;

    public function __construct(
        UserRepository $userRepository,
        WalletRepository $walletRepository,
        TransactionRepository $transactionRepository
    ){
        $this->userRepository = $userRepository;
        $this->walletRepository = $walletRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function getUsers()
    {
        $users = $this->userRepository->users();
        return $this->successResponse("User created successfully", $users, Response::HTTP_OK);
    }

    public function getUser($userUuid)
    {
        $user = $this->userRepository->user($userUuid);
        if (!$user) {
            return $this->failureResponse("User not found", null, Response::HTTP_BAD_REQUEST);
        }

        $wallets = $this->walletRepository->walletsByUserId($user->id);
        $transactions = $this->transactionRepository->userTransactions($user->id);
        return $this->successResponse("Record fetched successfully", [
            "user" => $user,
            "wallets" => $wallets,
            "transactions" => $transactions
        ], Response::HTTP_OK);
    }
}
