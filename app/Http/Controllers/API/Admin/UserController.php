<?php

namespace App\Http\Controllers\API\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\CreateUserRequest;
use App\Http\Resources\API\Admin\UserResource;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{

    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    // Get all users with balance
    public function index()
    {
        $users = $this->userRepository->getAllUsers();
        return ApiResponse::data(UserResource::collection($users)
            , ' Get All Users', 200);
    }

    // Get a single user by ID with balance
    public function show($id)
    {
        $user = $this->userRepository->getUserById($id);

        if (!$user) {
            return ApiResponse::errors('User not found.');
        }
        return ApiResponse::data(new UserResource($user)
            , ' Get Inf User', 200);
    }

    // Create a new user
    public function store(CreateUserRequest $request)
    {
        $user = $this->userRepository->createUser($request->validated());

        return ApiResponse::data(new UserResource($user)
            , ' Create New User', 200);
    }

    // Update a user's details
    public function update(Request $request, $id)
    {
        $user = $this->userRepository->updateUser($id, $request->all());

        return ApiResponse::data(new UserResource($user)
            , ' Update User', 200);
    }

    // Delete a user
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $this->userRepository->deleteUser($id);

        return response()->json(['message' => 'User deleted successfully']);
    }




}
