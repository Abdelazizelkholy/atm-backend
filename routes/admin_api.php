<?php


use App\Http\Controllers\API\Admin\AdminAuthController;
use App\Http\Controllers\API\Admin\TransactionController;
use App\Http\Controllers\API\Admin\UserController;
use Illuminate\Support\Facades\Route;


Route::post('/login',  [AdminAuthController::class , 'login']);

Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class)->except(['create', 'edit']);
    Route::get('transactions', [TransactionController::class, 'transactions']);
});



