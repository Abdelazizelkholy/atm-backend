<?php
namespace App\Repositories\Client;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class ClientRepository implements ClientRepositoryInterface
{



    public function updateBalance(int $userId, float $amount, string $operation): bool
    {
        // Find the user with their account
        $user = User::with('account')->find($userId);

        if (!$user || !$user->account) {
            return false;
        }

        $account = $user->account;

        if ($operation === self::OPERATION_SUBTRACT && $account->balance == 0) {
            return false;
        }

        if ($operation === self::OPERATION_SUBTRACT) {
            if ($account->balance < $amount) {
                return false;
            }
            $account->balance -= $amount;
        }

        elseif ($operation === self::OPERATION_ADD) {
            $account->balance += $amount;
        } else {
            return false;
        }
        return $account->save();
    }

    public function getBalance(int $userId): float
    {
        $user = User::with('account')->find($userId);

        return $user && $user->account ? $user->account->balance : 0.0;
    }




}

