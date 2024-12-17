<?php
namespace App\Repositories\Client;

use App\Models\Transaction;

class ClientTransactionRepository implements ClientTransactionRepositoryInterface
{

    public function createTransaction(int $userId, string $type, float $amount)
    {
        return Transaction::create([
            'user_id' => $userId,
            'type' => $type,
            'amount' => $amount
        ]);
    }



}

