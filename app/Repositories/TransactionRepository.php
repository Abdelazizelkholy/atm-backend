<?php
// app/Repositories/TransactionRepository.php
namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function getAllTransactions(array $filters = [])
    {
        $query = Transaction::with('account');

        // Apply filters
        if ($query){
            if (isset($filters['user_id'])) {
                $query->where('account_id', $filters['user_id']);
            }

            if (isset($filters['type'])) {
                $query->where('type', $filters['type']);
            }

            return $query->orderBy('created_at', 'desc')->paginate(10);
        }
    }
}

