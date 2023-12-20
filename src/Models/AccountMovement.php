<?php

namespace Abather\MiniAccounting\Models;

use Abather\MiniAccounting\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AccountMovement extends Model
{
    const WITHDRAW = 'WITHDRAW';
    const DEPOSIT = 'DEPOSIT';
    protected $casts = [
        "data" => "array",
        "amount" => MoneyCast::class,
        "balance" => MoneyCast::class,
        "previous_balance" => MoneyCast::class,
    ];

    public function accountable(): morphTo
    {
        return $this->morphTo();
    }

    public function referencable(): morphTo
    {
        return $this->morphTo();
    }
}
