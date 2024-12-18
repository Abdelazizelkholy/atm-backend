<?php

namespace App\Http\Controllers\API\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{



    public function login(LoginRequest $request)
    {

        $validated = $request->validated();

        $user = User::where('email', $validated['username'])->first();
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return ApiResponse::errors('The provided credentials are incorrect.');
        }
        $token = $user->createToken('atm-backend')->accessToken;

        return ApiResponse::data(['token' => $token]
            , ' Login successful ', 200);

    }

}
