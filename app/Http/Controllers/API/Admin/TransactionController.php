<?php

namespace App\Http\Controllers\API\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Admin\TransactionCollection;
use App\Http\Resources\API\Admin\UserResource;
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

        return ApiResponse::data(new TransactionCollection($transactions)
            , ' Get All transactions', 200);

    }


}
