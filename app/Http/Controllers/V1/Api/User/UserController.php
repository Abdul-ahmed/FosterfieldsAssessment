<?php

namespace App\Http\Controllers\V1\Api\User;

use App\Http\Controllers\Controller;
use App\Repositories\V1\UserRepository;
use App\Repositories\V1\WalletRepository;
use App\Repositories\V1\WalletTypeRepository;
use App\Traits\ControllersTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules\Password;
use Laratrust\Models\Role;

class UserController extends Controller
{
    use ControllersTrait;

    const REQUIRED_STRING = "required|string";

    const SOMETIMES = "sometimes|";

    private $request;
    private $userRepository;
    private $walletTypeRepository;
    private $walletRepository;

    public function __construct(
        Request $request,
        UserRepository $userRepository,
        WalletTypeRepository $walletTypeRepository,
        WalletRepository $walletRepository
    ){
        $this->request = $request;
        $this->userRepository = $userRepository;
        $this->walletTypeRepository = $walletTypeRepository;
        $this->walletRepository = $walletRepository;
    }

    public function createUser()
    {
        $requestValidator = $this->validateCreateUserRequest();
        if ($requestValidator->fails()) {
            return $this->failureResponse($requestValidator->errors()->first(), null, Response::HTTP_BAD_REQUEST);
        }

        $createdUser = $this->userRepository->createUser($this->request->all());
        if ($createdUser) {
            $createdUser->addRole(Role::find(3));
            $defaultWalletType = $this->walletTypeRepository->defaultWallet();
            $this->walletRepository->createDefaultWallet($createdUser->id, $defaultWalletType->id);
        }

        $this->lastLogin($createdUser);
        $auth = $this->authToken($createdUser);
        return $this->successResponse("User created successfully", $auth, Response::HTTP_CREATED);
    }

    public function validateCreateUserRequest()
    {
        return Validator::make($this->request->all(), [
            "first_name" => self::REQUIRED_STRING,
            "middle_name" => self::SOMETIMES.self::REQUIRED_STRING,
            "last_name" => self::REQUIRED_STRING,
            "email" => self::REQUIRED_STRING."|email|unique:users",
            "country_code" => self::SOMETIMES.self::REQUIRED_STRING."|min:3",
            "phone_number" => self::SOMETIMES.self::REQUIRED_STRING."|unique:users|min:10",
            "password" => ["required", "string", Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised()]
        ]);
    }

    public function login()
    {
        $requestValidator = $this->validateLoginRequest();
        if ($requestValidator->fails()) {
            return $this->failureResponse($requestValidator->errors()->first(), null, Response::HTTP_BAD_REQUEST);
        }

        $login = $this->userRepository->login($this->request->all());
        if (!$login) {
            return $this->failureResponse('Invalid email or password', [], Response::HTTP_BAD_REQUEST);
        }

        $this->lastLogin($login);
        $auth = $this->authToken($login);
        return $this->successResponse("User authenticated successfully", $auth, Response::HTTP_OK);
    }

    public function validateLoginRequest()
    {
        return Validator::make($this->request->all(), [
            "email" => self::REQUIRED_STRING."|email",
            "password" => ["required", "string"]
        ]);
    }

    public function userDetails()
    {
        $user = Auth::guard('api')->user();
        $wallets = $this->walletRepository->walletsByUserId($user->id);
        return $this->successResponse("Record fetched successfully", [
            "user" => $user,
            "wallets" => $wallets
        ], Response::HTTP_OK);
    }

}
