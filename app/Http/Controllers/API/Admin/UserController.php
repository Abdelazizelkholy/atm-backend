<?php

namespace App\Http\Controllers\API\Admin;

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
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $users = $this->userRepository->getAllUsers();
        return UserResource::collection($users);
    }

    // Get a single user by ID with balance
    public function show($id)
    {
        $user = $this->userRepository->getUserById($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return new UserResource($user);
    }

    // Create a new user
    public function store(CreateUserRequest $request): UserResource
    {
        $user = $this->userRepository->createUser($request->validated());

        return new UserResource($user);
    }

    // Update a user's details
    public function update(Request $request, $id): UserResource
    {
        $user = $this->userRepository->updateUser($id, $request->all());

        return new UserResource($user);
    }

    // Delete a user
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $this->userRepository->deleteUser($id);

        return response()->json(['message' => 'User deleted successfully']);
    }




}
