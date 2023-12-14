<?php

namespace Abather\MiniAccounting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AccountMovement extends Model
{
    const WITHDRAW = 'WITHDRAW';
    const DEPOSIT = 'DEPOSIT';
    protected $casts = [
        "data" => "array",
        "balance" => "integer",
        "previous_balance" => "integer",
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
