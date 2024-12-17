<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{


    protected $fillable = [
        'account_id',
        'type',
        'amount'
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

}
