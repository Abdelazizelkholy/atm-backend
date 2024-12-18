<?php

namespace App\Repositories\Client;



interface ClientTransactionRepositoryInterface
{

    public const TYPE_DEPOSIT = 'deposit';
    public const TYPE_WITHDRAW = 'withdraw';
    public function createTransaction(int $userId, string $type, float $amount): bool;

    public function getTransactionsByUserId(int $userId);






}



