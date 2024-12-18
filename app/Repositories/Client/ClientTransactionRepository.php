<?php
namespace App\Repositories\Client;

use App\Models\Transaction;
use App\Models\User;

class ClientTransactionRepository implements ClientTransactionRepositoryInterface
{


    public function createTransaction(int $userId, string $type, float $amount): bool
    {
        return (bool)Transaction::create([
            'account_id' => $userId,
            'type' => $type,
            'amount' => $amount,
        ]);
    }

    public function getTransactionsByUserId(int $userId)
    {

        $user = User::with('account.transactions')->find($userId);

        if (!$user || !$user->account) {
            return collect();
        }

        return $user->account->transactions()->orderBy('created_at', 'desc')->get();
    }

}

