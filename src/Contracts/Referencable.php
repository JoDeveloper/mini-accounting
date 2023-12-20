<?php

namespace Abather\MiniAccounting\Contracts;

interface Referencable
{
    public function accountMovements();

    public function defaultTransactions();

    public function executeTransactions($transaction = "defaultTransactions");

    public function getDepositAttribute();

    public function getBalanceAttribute();

    public function getWithdrawAttribute();
}
