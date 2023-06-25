<?php

namespace App\Http\Controllers\V1\Api\User;

use App\Http\Controllers\Controller;
use App\Repositories\V1\TransactionRepository;
use App\Repositories\V1\WalletRepository;
use App\Repositories\V1\WalletTypeRepository;
use App\Traits\ControllersTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WalletController extends Controller
{
    use ControllersTrait;

    const REQUIRED_STRING = "required|string";
    const REQUIRED_NUMERIC = "required|numeric";

    private $request;
    private $walletTypeRepository;
    private $walletRepository;
    private $transactionRepository;

    public function __construct(
        Request $request,
        WalletTypeRepository $walletTypeRepository,
        WalletRepository $walletRepository,
        TransactionRepository $transactionRepository
    ){
        $this->request = $request;
        $this->walletTypeRepository = $walletTypeRepository;
        $this->walletRepository = $walletRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function createWallet()
    {
        $requestValidator = $this->validateCreateWalletRequest();
        if ($requestValidator->fails()) {
            return $this->failureResponse($requestValidator->errors()->first(), null, Response::HTTP_BAD_REQUEST);
        }

        $walletType = $this->walletTypeRepository->walletTypeByUuid($this->request->wallet_type_uuid);
        if (!$walletType) {
            return $this->failureResponse("Issue with the request wallet type", null, Response::HTTP_BAD_REQUEST);
        }

        $walletExistByUser = $this->walletRepository->walletExistByUser($walletType->id, Auth::guard('api')->user()->id);
        if ($walletExistByUser) {
            return $this->failureResponse("Wallet already exist by user", null, Response::HTTP_BAD_REQUEST);
        }

        $createdWallet = $this->walletRepository->createWallet($walletType->id, Auth::guard('api')->user()->id);
        return $this->successResponse("Wallet created successfully", $createdWallet, Response::HTTP_CREATED);
    }

    public function validateCreateWalletRequest()
    {
        return Validator::make($this->request->all(), [
            "wallet_type_uuid" => self::REQUIRED_STRING,
        ]);
    }

    public function fundWallet()
    {
        $requestValidator = $this->validateFundWalletRequest();
        if ($requestValidator->fails()) {
            return $this->failureResponse($requestValidator->errors()->first(), null, Response::HTTP_BAD_REQUEST);
        }

        $wallet = $this->walletRepository->walletByUser($this->request->wallet_uuid, Auth::guard('api')->user()->id);
        if (!$wallet) {
            return $this->failureResponse("Wallet not found", null, Response::HTTP_BAD_REQUEST);
        }

        $fund = $this->transactionRepository->credit($wallet, $this->request->amount);
        return $this->successResponse("Wallet created successfully", $fund, Response::HTTP_CREATED);
    }

    public function validateFundWalletRequest()
    {
        return Validator::make($this->request->all(), [
            "wallet_uuid" => self::REQUIRED_STRING,
            "amount" => self::REQUIRED_NUMERIC
        ]);
    }
}
