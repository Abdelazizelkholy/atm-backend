<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\TransactionResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{


    public function login(LoginRequest $request)
    {
        $credentials = $request->only('card_number', 'pin');

        $user = User::whereHas('account', function ($query) use ($credentials) {
            $query->where('card_number', $credentials['card_number']);
        })->first();

        if (!$user || !Hash::check($credentials['pin'], $user->account->pin)) {
            return ApiResponse::errors('Invalid card number or PIN.');
        }

        $token = $user->createToken('ATM Login')->accessToken;

        return ApiResponse::data(['token' => $token]
            , ' Login successful ', 200);
    }


}
