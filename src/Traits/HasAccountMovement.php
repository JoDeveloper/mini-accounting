<?php

namespace Abather\MiniAccounting\Traits;

use Abather\MiniAccounting\Exceptions\DuplicateEntryException;
use Abather\MiniAccounting\Models\AccountMovement;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasAccountMovement
{
    public function __call($method, $parameters)
    {
        if (in_array($method, ["deposit", 'withdraw'])) {
            return $this->createAccountMovement($method, ...$parameters);
        }

        return parent::__call($method, $parameters);
    }

    public function accountMovements(): MorphMany
    {
        return $this->morphMany(AccountMovement::class, 'accountable');
    }

    public function depositAccountMovements(): MorphMany
    {
        return $this->morphMany(AccountMovement::class, 'accountable')
            ->whereType("DEPOSIT");
    }

    public function withdrawAccountMovements(): MorphMany
    {
        return $this->morphMany(AccountMovement::class, 'accountable')
            ->whereType("WITHDRAW");
    }

    public function lastAccountMovement(): MorphOne
    {
        return $this->morphOne(AccountMovement::class, 'accountable')
            ->latestOfMany();
    }

    public function getBalanceAttribute()
    {
        $this->refresh();
        return $this->lastAccountMovement ? $this->lastAccountMovement->balance : 0;
    }

    public function balanceAtEndOfMonth($date)
    {
        $account_movement = $this->accountMovements()
            ->where('created_at', "<=", Carbon::parse($date)->endOfMonth())
            ->orderByDesc('created_at')->first();

        return $account_movement ? $account_movement->balance : 0;
    }

    private function createAccountMovement($type, $description, $amount, $reference, $notes = null, array $data = [])
    {
        if (config("mini-accounting.prevent_duplication")) {
            throw_if($this->isDuplicated($reference, $type), new DuplicateEntryException);
        }

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

    private function isDuplicated($reference, $type)
    {
        return $this->accountMovements()
            ->where('reference_id', $reference->id)
            ->where('reference_type', get_class($reference))
            ->where('type', $type)
            ->exists();
    }
}
