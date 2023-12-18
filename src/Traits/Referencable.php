<?php

namespace Abather\MiniAccounting\Traits;

use Abather\MiniAccounting\Exceptions\DuplicateEntryException;
use Abather\MiniAccounting\Models\AccountMovement;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Referencable
{
    public function accountMovements(): MorphMany
    {
        return $this->morphMany(AccountMovement::class, 'reference');
    }

    private function createAccountMovement($type, $description, $amount, $account, $notes = null, array $data = [])
    {
        if (config("mini-accounting.prevent_duplication")) {
            throw_if($this->isDuplicated($account, $type), new DuplicateEntryException);
        }

        $factor = $type == AccountMovement::WITHDRAW ? -1 : 1;
        $account_movement = new AccountMovement;
        $account_movement->description = $description;
        $account_movement->amount = $amount;
        $account_movement->type = $type;
        $account_movement->previous_balance = $this->balance;
        $account_movement->balance = $this->balance + ($amount * $factor);
        $account_movement->accountable_id = $account->id;
        $account_movement->accountable_type = get_class($account);
        $account_movement->data = $data;
        $account_movement->notes = $notes;

        return $this->accountMovements()->save($account_movement);
    }

    public function deposit(
        $description,
        $amount,
        $account,
        $notes = null,
        array $data = []
    ) {
        return $this->createAccountMovement(
            AccountMovement::DEPOSIT,
            $description,
            $amount,
            $account,
            $notes,
            $data
        );
    }

    public function withdraw(
        $description,
        $amount,
        $account,
        $notes = null,
        array $data = []
    ) {
        return $this->createAccountMovement(
            AccountMovement::WITHDRAW,
            $description,
            $amount,
            $account,
            $notes,
            $data
        );
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

    public function executeTransactions()
    {
        foreach ($this->defaultTransactions() as $create_transaction) {
            $create_transaction->generateAccountTransaction();
        }
    }

    private function isDuplicated($account, $type)
    {
        return $this->accountMovements()
            ->where('accountable_id', $account->id)
            ->where('accountable_type', get_class($account))
            ->where('type', $type)
            ->exists();
    }
}
