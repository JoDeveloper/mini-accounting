<?php

namespace Abather\MiniAccounting\Traits;

use Abather\MiniAccounting\Models\AccountMovement;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Referencable
{
    public function accountMovements(): MorphMany
    {
        return $this->morphMany(AccountMovement::class, 'referencable');
    }

    public function getDepositAttribute()
    {
        return $this->accountMovements()->whereType(AccountMovement::DEPOSIT)
            ->sum('amount') ?? 0;
    }

    public function getWithdrawAttribute()
    {
        return $this->accountMovements()->whereType(AccountMovement::WITHDRAW)
            ->sum('amount') ?? 0;
    }

    public function getBalanceAttribute()
    {
        return $this->deposit - $this->withdraw;
    }

    public function transactions()
    {
        foreach ($this->defaultTransactions() as $create_transaction) {
            $create_transaction->generateAccountTransaction();
        }
    }
}
