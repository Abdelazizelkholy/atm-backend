<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{


    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $credentials = $request->only('card_number', 'pin');

        $user = User::whereHas('account', function ($query) use ($credentials) {
            $query->where('card_number', $credentials['card_number']);
        })->first();

        if (!$user || !Hash::check($credentials['pin'], $user->account->pin)) {
            return response()->json(['error' => 'Invalid card number or PIN'], 401);
        }

        $token = $user->createToken('ATM Login')->accessToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
        ], 200);
    }


}
