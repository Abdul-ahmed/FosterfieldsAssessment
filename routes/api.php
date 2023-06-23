<?php

use App\Http\Controllers\V1\Api\User\UserController;
use App\Http\Controllers\V1\Api\User\WalletTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'prefix' => '/v1/user',
    'middleware' => ['headers.authorization']
], function () {
    Route::get('/wallet-types', [WalletTypeController::class, 'getWalletTypes'])->name('wallet.types');
    Route::post('/create-user', [UserController::class, 'createUser'])->name('user.create');

});

Route::group([
    'prefix' => '/v1/admin',
    'middleware' => ['headers.authorization']
], function () {
    Route::get('/users', [\App\Http\Controllers\V1\Api\Admin\UserController::class, 'getUsers'])->name('users.fetch');
    Route::get('/user/{user_uuid}', [\App\Http\Controllers\V1\Api\Admin\UserController::class, 'getUser'])->name('user.fetch');
});

Route::group([
    'prefix' => '/response'
], function () {
    Route::get('/failed', function () {
        return response()->json([
            'status' => 'error',
            'code' => Response::HTTP_UNAUTHORIZED,
            'message' => "api-key is invalid or missing from the headers",
            'data' => null
        ], Response::HTTP_UNAUTHORIZED);
    });

    Route::post('/failed', function () {
        return response()->json([
            'status' => 'error',
            'code' => Response::HTTP_UNAUTHORIZED,
            'message' => "api-key is invalid or missing from the headers",
            'data' => null
        ], Response::HTTP_UNAUTHORIZED);
    });
});
