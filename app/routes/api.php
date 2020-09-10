<?php

use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\MessageController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth.guest:api')
    ->group(function () {
        Route::resource('message', MessageController::class)
            ->only(['store', 'index']);
    });

Route::prefix('auth')->group(function () {
    Route::post('register', RegisterController::class);
});
