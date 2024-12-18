<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\DepositRequest;
use App\Http\Requests\WithdrawRequest;
use App\Http\Resources\TransactionResource;
use App\Repositories\Client\ClientRepository;
use App\Repositories\Client\ClientRepositoryInterface;
use App\Repositories\Client\ClientTransactionRepository;
use App\Repositories\Client\ClientTransactionRepositoryInterface;
use Illuminate\Http\Request;
use Modules\Accounts\Http\Resources\Api\ProfileResource;

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

    public function deposit(DepositRequest $request)
    {
        $user = auth()->user();
        $amount = $request->validated()['amount'];

        $balanceUpdated = $this->clientRepository->updateBalance(
            $user->id,
            $amount,
            ClientRepositoryInterface::OPERATION_ADD
        );

        if (!$balanceUpdated) {
            return ApiResponse::errors('Failed to update balance.');
        }

        $this->clientTransactionRepository->createTransaction(
            $user->id,
            ClientTransactionRepositoryInterface::TYPE_DEPOSIT,
            $amount
        );


        return ApiResponse::data( [ 'balance' => $this->clientRepository->getBalance($user->id)]
            , ' Deposit successful ', 200);
    }

    public function withdraw(WithdrawRequest $request)
    {
        $user = auth()->user();
        $amount = $request->validated()['amount'];


        if ($user->account->balance < $amount) {
            return ApiResponse::errors('Insufficient balance.');
        }

        $this->clientRepository->updateBalance($user->id, $amount, ClientRepositoryInterface::OPERATION_SUBTRACT);

        $this->clientTransactionRepository->createTransaction(
            $user->id,
            ClientTransactionRepositoryInterface::TYPE_WITHDRAW,
            $amount
        );


        return ApiResponse::data( [ 'balance' => $this->clientRepository->getBalance($user->id)]
            , ' Withdrawal successful ', 200);
    }


    public function getBalance()
    {
        $user = auth()->user();

        if (!$user->account) {
            return ApiResponse::errors('Account not found.');
        }


        return ApiResponse::data( [ 'balance' => $this->clientRepository->getBalance($user->id)]
            , ' return balance ', 200);
    }

    public function getTransactions()
    {

        $user = auth()->user();

        $transactions = $this->clientTransactionRepository->getTransactionsByUserId($user->id);

        if ($transactions->isEmpty()) {
            return ApiResponse::errors('No transactions found.');
        }

        return ApiResponse::data(TransactionResource::collection($transactions)
            , ' Get All Transactions ', 200);
    }






}
