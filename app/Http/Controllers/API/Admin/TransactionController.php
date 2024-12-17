<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Admin\TransactionCollection;
use App\Repositories\TransactionRepositoryInterface;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    protected $transactionRepository;

    public function __construct( TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }


    public function transactions(Request $request): TransactionCollection
    {

        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'type' => 'nullable|in:deposit,withdraw',
        ]);

        $transactions = $this->transactionRepository->getAllTransactions($validated);

        return new TransactionCollection($transactions);

    }


}
