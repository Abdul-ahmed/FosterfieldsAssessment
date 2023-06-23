<?php

namespace App\Http\Controllers\V1\Api\User;

use App\Http\Controllers\Controller;
use App\Repositories\V1\WalletTypeRepository;
use App\Traits\ControllersTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WalletTypeController extends Controller
{
    use ControllersTrait;

    private $walletTypeRepository;

    public function __construct(WalletTypeRepository $walletTypeRepository){
        $this->walletTypeRepository = $walletTypeRepository;
    }

    public function getWalletTypes()
    {
        $walletTypes = $this->walletTypeRepository->walletTypes();
        return $this->successResponse("Record fetched successfully", $walletTypes, Response::HTTP_OK);
    }
}
