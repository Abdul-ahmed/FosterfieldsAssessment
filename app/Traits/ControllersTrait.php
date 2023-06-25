<?php

namespace App\Traits;

trait ControllersTrait
{
    public function successResponse($message, $data, $code)
    {
        return response()->json([
            'status' => 'success',
            'code' => $code,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public function failureResponse($message, $data, $code)
    {
        return response()->json([
            'status' => 'error',
            'code' => $code,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public function authToken($user)
    {
        $tokenResult = $user->createToken('Personal Access Token');
        $accessToken = $tokenResult->accessToken;
        $expiresIn = $tokenResult->token->expires_at;
        return [
            "access_token" => $accessToken,
            "expires_in" => $expiresIn
        ];
    }

    public function lastLogin($user)
    {
        $user->update([
            "last_login" => now()
        ]);
    }

}
