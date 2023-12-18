<?php

namespace Abather\MiniAccounting\Contracts;

interface Referencable
{
    public function accountMovements();

    public function defaultTransactions();

    public function transactions();

    public function deposit($description, $amount, $account, $notes = null, array $data = []);

    public function withdraw($description, $amount, $account, $notes = null, array $data = []);

    public function getDepositAttribute();

    public function getBalanceAttribute();

    public function getWithdrawAttribute();
}
