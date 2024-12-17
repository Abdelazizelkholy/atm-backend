<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientTransactionController;
use Illuminate\Support\Facades\Route;


Route::post('login', [AuthController::class, 'login']);


Route::middleware(['auth:api'])->group(function () {
    Route::post('deposit', [ClientTransactionController::class, 'deposit']);
    Route::post('withdraw', [ClientTransactionController::class, 'withdraw']);
});
