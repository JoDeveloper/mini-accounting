<?php

namespace Abather\MiniAccounting\Traits;

use Abather\MiniAccounting\Models\AccountMovement;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasAccountMovement
{
    public function accountMovements(): MorphMany
    {
        return $this->morphMany(AccountMovement::class, 'accountable');
    }

    public function lastAccountMovement(): MorphOne
    {
        return $this->morphOne(AccountMovement::class, 'accountable')
            ->latestOfMany();
    }

    public function getBalanceAttribute()
    {
        return $this->lastAccountMovement ? $this->lastAccountMovement->balance : 0;
    }

    public function balanceAtEndOfMonth($date)
    {
        $account_movement = $this->accountMovements()->whereMonth('created_at', $date)
            ->orderByDesc('created_at')->first();

        return $account_movement ? $account_movement->balance : 0;
    }

    private function createAccountMovement($type, $description, $amount, $reference, $notes = null, array $data = [])
    {
        $factor = $type == AccountMovement::WITHDRAW ? -1 : 1;
        $account_movement = new AccountMovement;
        $account_movement->description = $description;
        $account_movement->amount = $amount;
        $account_movement->type = $type;
        $account_movement->previous_balance = $this->balance;
        $account_movement->balance = $this->balance + ($amount * $factor);
        $account_movement->reference_id = $reference->id;
        $account_movement->reference_type = get_class($reference);
        $account_movement->data = $data;
        $account_movement->notes = $notes;

        return $this->accountMovements()->save($account_movement);
    }

    public function withdraw($description, $amount, $reference, $notes = null, array $data = [])
    {
        return $this->createAccountMovement(
            AccountMovement::WITHDRAW,
            $description,
            $amount,
            $reference,
            $notes,
            $data
        );
    }

    public function deposit($description, $amount, $reference, $notes = null, array $data = [])
    {
        return $this->createAccountMovement(
            AccountMovement::DEPOSIT,
            $description,
            $amount,
            $reference,
            $notes,
            $data
        );
    }
}
