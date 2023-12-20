<?php

namespace Workbench\App\Models;

use Abather\MiniAccounting\Contracts\Referencable;
use Abather\MiniAccounting\Objects\Account;
use Abather\MiniAccounting\Objects\Calculations\Equal;
use Abather\MiniAccounting\Objects\Calculations\Factors\StaticFactor;
use Abather\MiniAccounting\Objects\Calculations\Percentage;
use Abather\MiniAccounting\Objects\Calculations\Subtraction;
use Abather\MiniAccounting\Objects\Transactions\Deposit;
use Abather\MiniAccounting\Objects\Transactions\Withdraw;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bill extends Model implements Referencable
{
    use \Abather\MiniAccounting\Traits\Referencable;

    public function defaultTransactions(): array
    {
        return [
            Withdraw::make($this, "description")
                ->setAccount(Account::make(\App\Models\User::class)
                    ->relationship("user"))
                ->setCalculation(Equal::make()->resource($this, "amount")),

            Deposit::make($this, "deposit to system")
                ->setAccount(Account::make(\App\Models\System::class, System::first()))
                ->setCalculation(Percentage::make()->resource($this, "amount")
                    ->factor(StaticFactor::make()->value(10))),

            Deposit::make($this, "description")
                ->setAccount(Account::make(\App\Models\User::class)
                    ->relationship("user"))
                ->setCalculation(Subtraction::make()->resource($this, "amount")
                    ->factor(StaticFactor::make()->value(50)))
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
