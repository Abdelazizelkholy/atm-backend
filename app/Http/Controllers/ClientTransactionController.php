<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepositRequest;
use App\Http\Requests\WithdrawRequest;
use App\Http\Resources\TransactionResource;
use App\Repositories\Client\ClientRepository;
use App\Repositories\Client\ClientRepositoryInterface;
use App\Repositories\Client\ClientTransactionRepository;
use App\Repositories\Client\ClientTransactionRepositoryInterface;
use Illuminate\Http\Request;

class ClientTransactionController extends Controller
{
    protected ClientRepositoryInterface $clientRepository;
    protected ClientTransactionRepositoryInterface $clientTransactionRepository;

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
        $amount = $request->validated()['amount'];

        $balanceUpdated = $this->clientRepository->updateBalance(
            $user->id,
            $amount,
            ClientRepositoryInterface::OPERATION_ADD
        );

        if (!$balanceUpdated) {
            return response()->json([
                'error' => 'Failed to update balance.',
            ], 400);
        }

        $this->clientTransactionRepository->createTransaction(
            $user->id,
            ClientTransactionRepositoryInterface::TYPE_DEPOSIT,
            $amount
        );

        return response()->json([
            'message' => 'Deposit successful',
            'balance' => $this->clientRepository->getBalance($user->id),
        ], 200);
    }

    public function withdraw(WithdrawRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        $amount = $request->validated()['amount'];


        if ($user->account->balance < $amount) {
            return response()->json([
                'error' => 'Insufficient balance',
            ], 400);
        }

        $this->clientRepository->updateBalance($user->id, $amount, ClientRepositoryInterface::OPERATION_SUBTRACT);

        $this->clientTransactionRepository->createTransaction(
            $user->id,
            ClientTransactionRepositoryInterface::TYPE_WITHDRAW,
            $amount
        );

        return response()->json([
            'message' => 'Withdrawal successful',
            'balance' => $this->clientRepository->getBalance($user->id),
        ], 200);
    }


    public function getBalance(): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();

        if (!$user->account) {
            return response()->json([
                'error' => 'Account not found.',
            ], 404);
        }

        return response()->json([
            'balance' => $this->clientRepository->getBalance($user->id),
        ], 200);
    }

    public function getTransactions(): \Illuminate\Http\JsonResponse
    {

        $user = auth()->user();

        $transactions = $this->clientTransactionRepository->getTransactionsByUserId($user->id);

        if ($transactions->isEmpty()) {
            return response()->json([
                'message' => 'No transactions found.',
            ], 200);
        }

        return response()->json([
            'transactions' => TransactionResource::collection($transactions),
        ], 200);
    }






}
