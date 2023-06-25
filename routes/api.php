<?php

use App\Http\Controllers\V1\Api\User\TransactionController;
use App\Http\Controllers\V1\Api\User\UserController;
use App\Http\Controllers\V1\Api\User\WalletController;
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
    'prefix' => '/v1/auth',
    'middleware' => ['headers.authorization']
], function () {
    Route::post('/register', [UserController::class, 'createUser'])->name('user.create');
    Route::post('/login', [UserController::class, 'login'])->name('login');
});

Route::group([
    'prefix' => '/v1/user',
    'middleware' => ['headers.authorization', 'auth:api']
], function () {
    Route::get('/details', [UserController::class, 'userDetails'])->name('user.details');
    Route::post('/fund-wallet', [WalletController::class, 'fundWallet'])->name('wallet.fund');
    Route::get('/wallet-types', [WalletTypeController::class, 'getWalletTypes'])->name('wallet.types');
    Route::post('/create-wallet', [WalletController::class, 'createWallet'])->name('wallet.create');
    Route::post('/send-money', [TransactionController::class, 'sendMoney'])->name('money.send');
});

Route::group([
    'prefix' => '/v1/admin',
    'middleware' => ['headers.authorization', 'auth:api', 'headers.admin']
], function () {
    Route::get('/users', [\App\Http\Controllers\V1\Api\Admin\UserController::class, 'getUsers'])->name('users.fetch');
    Route::get('/user/{user_uuid}', [\App\Http\Controllers\V1\Api\Admin\UserController::class, 'getUser'])->name('user.fetch');
    Route::get('/wallets', [\App\Http\Controllers\V1\Api\Admin\WalletController::class, 'getWallets'])->name('wallets');
    Route::get('/wallet/{wallet_uuid}', [\App\Http\Controllers\V1\Api\Admin\WalletController::class, 'getWallet'])->name('wallet');
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

    Route::group([
        'prefix' => '/admin'
    ], function () {
        Route::get('/failed', function () {
            return response()->json([
                'status' => 'error',
                'code' => Response::HTTP_UNAUTHORIZED,
                'message' => "You're not authorize to access this route, kindly request for admin permission.",
                'data' => null
            ], Response::HTTP_UNAUTHORIZED);
        });

        Route::post('/failed', function () {
            return response()->json([
                'status' => 'error',
                'code' => Response::HTTP_UNAUTHORIZED,
                'message' => "You're not authorize to access this route, kindly request for admin permission.",
                'data' => null
            ], Response::HTTP_UNAUTHORIZED);
        });
    });
});
