<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{


    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     *  Admin Login
     */
    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {

        $validated = $request->validated();

        $user = User::where('email', $validated['username'])->first();
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['The provided credentials are incorrect.'],
            ]);
        }
        $token = $user->createToken('atm-backend')->accessToken;
        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
        ]);
    }

}
