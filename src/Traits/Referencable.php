<?php

namespace Abather\MiniAccounting\Traits;

use Abather\MiniAccounting\Models\AccountMovement;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Referencable
{
//    const FACTOR_TYPE_STATIC = "static";
//    const FACTOR_TYPE_VARIABLE = "variable";
//    const RELATED_TYPE_RELATION = "relation";
//    const RELATED_TYPE_MODEL = "model";
//    const CALCULATION_METHOD_MULTIPLICATION = "multiplication";
//    const CALCULATION_METHOD_PERCENTAGE = "percentage";
//    const CALCULATION_METHOD_EQUAL = "equal";
//    const CALCULATION_METHOD_SUBTRACT = "subtract";

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

    public function creationTransactions()
    {
        foreach ($this->create_transactions as $create_transaction) {
            $model = $this->{$this->getRelated($create_transaction['related'])};
            dd($model);
            $model->{$create_transaction['type']}(
                $create_transaction['description'],
                $this->getAmount($create_transaction['calculation']),
                $this
            );
        }
    }

    public function getRelated($related)
    {
        if ($related["type"] == "relation") {
            return $this->{$related["value"]};
        } elseif ($related["type"] == "model") {
            $related["model"]::find($related["value"]);
        }
        return null;
    }

    public function getAmount($calculation)
    {
        $base_amount = $this->{$calculation["variable"]};
        $factor = $this->getFactor($calculation['factor']);
        return $this->{$calculation['method']}($base_amount, $factor);
    }

    public function getFactor($factor)
    {
        if ($factor['type'] == "static") {
            return $factor['value'];
        } elseif ($factor['type'] == "variable") {
            return $this->{$factor['value']};
        }

        return 0;
    }

    private function equal($base_amount, $factor = 0)
    {
        return $base_amount;
    }

    private function percentage($base_amount, $factor)
    {
        return $base_amount * ($factor / 100);
    }

    private function subtract($base_amount, $factor)
    {
        return $base_amount - $factor;
    }
}
