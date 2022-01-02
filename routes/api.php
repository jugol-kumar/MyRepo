<?php

use App\Http\Controllers\Api\AirlinesController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
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





Route::group([
], function () {
    Route::post('login',      [AuthController::class, "login"]);
    Route::post('checkToken', [AuthController::class, "checkToken"]);
    Route::post('logout',     [AuthController::class, "logout"]);
});



Route::get( "all-user",       [AirlinesController::class, 'index']);
Route::post("add-user",       [AirlinesController::class, 'store'] );
Route::post("edit-user",      [AirlinesController::class, 'update']);
Route::post("delete-user",    [AirlinesController::class, 'delete']);
