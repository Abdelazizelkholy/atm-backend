<?php

namespace App\Http\Resources\API\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => [
                'id' => $this->account->id,
                'name' => $this->account->user->name,
                'email' => $this->account->user->email,
            ],
            'type' => $this->type,
            'amount' => $this->amount,
            'transaction_date' => $this->created_at,
        ];
    }
}
