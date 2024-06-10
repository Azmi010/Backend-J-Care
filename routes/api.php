<?php

use App\Http\Controllers\AduanController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::put('update', [AuthController::class, 'updateAkun']);

    Route::post('aduans', [AduanController::class, 'store']);
    Route::get('aduans', [AduanController::class, 'index']);
    Route::delete('aduans/{userId}', [AduanController::class, 'destroy']);
    Route::put('aduans/{aduanId}', [AduanController::class, 'updateLike']);
    Route::put('aduans/{aduanId}/status', [AduanController::class, 'updateStatus']);
});

// Route::apiResource('aduans', AduanController::class);
