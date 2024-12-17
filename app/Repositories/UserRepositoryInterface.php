<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    public function getAllUsers(): Collection;

    public function getUserById(int $userId): ?User;

    public function createUser(array $data): User;

    public function updateUser(int $userId, array $data): User;

    public function deleteUser(int $userId): bool;
}


