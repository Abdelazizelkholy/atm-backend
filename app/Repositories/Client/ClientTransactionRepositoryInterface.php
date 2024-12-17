<?php

namespace App\Repositories\Client;



interface ClientTransactionRepositoryInterface
{

    public function createTransaction(int $userId, string $type, float $amount);





}



