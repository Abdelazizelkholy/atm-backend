<?php

namespace App\Repositories\Client;



interface ClientRepositoryInterface
{

    public function updateBalance(int $userId, float $amount);

    public function withdraw(int $userId, float $amount);

}



