<?php

namespace App\Repositories\Client;



interface ClientRepositoryInterface
{

    public const OPERATION_ADD = 'add';
    public const OPERATION_SUBTRACT = 'subtract';

    public function updateBalance(int $userId, float $amount, string $operation): bool;

    public function getBalance(int $userId): float;


}



