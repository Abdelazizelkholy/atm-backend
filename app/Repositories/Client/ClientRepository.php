<?php
namespace App\Repositories\Client;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class ClientRepository implements ClientRepositoryInterface
{


    public function updateBalance(int $userId, float $amount)
    {
        $user = User::find($userId);
        if ($user) {
            $user->balance += $amount;
            return $user->save();
        }
        return false;
    }

    public function withdraw(int $userId, float $amount)
    {

        if ($amount <= 0) {
            return false;
        }

        $user = User::find($userId);

        if (!$user || $user->balance < $amount) {
            return false;
        }

        DB::beginTransaction();

        try {
            $user->balance -= $amount;
            $user->save();

            DB::commit();

            return true;  // Withdrawal successful
        } catch (\Exception $e) {
            DB::rollBack();
            return false;  // Withdrawal failed
        }
    }



}

