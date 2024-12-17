<?php
// app/Repositories/UserRepository.php
namespace App\Repositories;

use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function getAllUsers(): Collection
    {
        return User::role('user')
        ->with('roles')
        ->get();
    }

    public function getUserById(int $userId): ?User
    {
        return User::where('id', $userId)
            ->role('user')
            ->with('roles')
            ->first();
    }

    public function createUser(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email']
        ]);


        $user->assignRole('user');

        Account::create([
            'user_id' => $user->id,
            'card_number' => random_int(1000000000000000, 9999999999999999),
            'pin' => bcrypt('1234'),
        ]);

        return $user;
    }

    public function updateUser(int $userId, array $data): User
    {
        $user = User::findOrFail($userId);

        $user->update([
            'name' => $data['name'] ?? $user->name,
            'email' => $data['email'] ?? $user->email,
        ]);

        $account = $user->account;

            if (!$account) {

                Account::create([
                    'user_id' => $user->id,
                    'card_number' =>  random_int(1000000000000000, 9999999999999999),
                    'pin' => bcrypt('1234'),
                ]);
            } else {

                $account->update([
                    'card_number' =>  $account->card_number,
                    'pin' => $account->pin,
                ]);

            }

        return $user;
    }

    public function deleteUser(int $userId): bool
    {
        return User::destroy($userId);
    }
}

