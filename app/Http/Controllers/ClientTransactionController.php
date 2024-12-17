<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepositRequest;
use App\Http\Requests\WithdrawRequest;
use App\Repositories\Client\ClientRepositoryInterface;
use App\Repositories\Client\ClientTransactionRepositoryInterface;
use Illuminate\Http\Request;

class ClientTransactionController extends Controller
{
    protected $clientRepository;
    protected $clientTransactionRepository;

    public function __construct(
        ClientRepositoryInterface $clientRepository,
        ClientTransactionRepositoryInterface $clientTransactionRepository
    ) {
        $this->clientRepository = $clientRepository;
        $this->clientTransactionRepository = $clientTransactionRepository;
    }

    public function deposit(DepositRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();

        // Validate the amount to deposit
        $amount = $request->validated()['amount'];

        $this->clientRepository->updateBalance($user->id, $amount);

        $this->clientTransactionRepository->createTransaction($user->id, 'deposit', $amount);

        // Return the updated balance
        return response()->json([
            'message' => 'Deposit successful',
            'balance' => $user->balance,
        ], 200);
    }


    public function withdraw(WithdrawRequest $request): \Illuminate\Http\JsonResponse
    {
        $userId = auth()->id();
        $amount = $request->amount;


        $withdrawSuccess = $this->clientRepository->withdraw($userId, $amount);

        if (!$withdrawSuccess) {
            return response()->json(['error' => 'Insufficient balance or withdrawal failed.'], 400);
        }


        $user = auth()->user();
        $this->clientTransactionRepository->createTransaction($userId, 'withdrawal', $amount);

        return response()->json(['message' => 'Withdrawal successful.'], 200);
    }


}
