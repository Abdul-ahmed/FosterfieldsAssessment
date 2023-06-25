<?php

namespace App\Http\Controllers\V1\Api\User;

use App\Http\Controllers\Controller;
use App\Repositories\V1\TransactionRepository;
use App\Repositories\V1\WalletRepository;
use App\Traits\ControllersTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    use ControllersTrait;

    const REQUIRED_STRING = "required|string";
    const REQUIRED_NUMERIC = "required|numeric";


    private $request;
    // private $userRepository;
    // private $walletTypeRepository;
    private $walletRepository;
    private $transactionRepository;

    public function __construct(
        Request $request,
        // UserRepository $userRepository,
        // WalletTypeRepository $walletTypeRepository,
        WalletRepository $walletRepository,
        TransactionRepository $transactionRepository
    ){
        $this->request = $request;
        // $this->userRepository = $userRepository;
        // $this->walletTypeRepository = $walletTypeRepository;
        $this->walletRepository = $walletRepository;
        $this->transactionRepository = $transactionRepository;

    }

    public function sendMoney()
    {
        $requestValidator = $this->validateSendMoneyRequest();
        if ($requestValidator->fails()) {
            return $this->failureResponse($requestValidator->errors()->first(), null, Response::HTTP_BAD_REQUEST);
        }

        $from = $this->walletRepository->walletByUser($this->request->from_wallet_uuid, Auth::guard('api')->user()->id);
        $to = $this->walletRepository->walletByUser($this->request->to_wallet_uuid, Auth::guard('api')->user()->id);
        if (!$from || $from->balance < $this->request->amount || !$to) {
            return $this->failureResponse("Wallet not found or balance less than required amount", null, Response::HTTP_BAD_REQUEST);
        }

        $transaction = $this->transactionRepository->sendMoney($from, $to, $this->request->amount);
        return $this->successResponse("Transaction successfully", $transaction, Response::HTTP_CREATED);
    }

    public function validateSendMoneyRequest()
    {
        return Validator::make($this->request->all(), [
            "from_wallet_uuid" => self::REQUIRED_STRING,
            "to_wallet_uuid" => self::REQUIRED_STRING,
            "amount" => self::REQUIRED_NUMERIC,
        ]);
    }
}
