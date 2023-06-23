<?php

use App\Http\Controllers\V1\Api\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    'prefix' => '/v1/user'
], function () {
    Route::post('/create-user', [UserController::class, 'createUser'])->name('user.create');
});

Route::group([
    'prefix' => '/v1/admin'
], function () {
    Route::get('/', function () {
        return response()->json([
            "message"=> "Welcome to admin"
        ]);
    })->name('admin');
});
