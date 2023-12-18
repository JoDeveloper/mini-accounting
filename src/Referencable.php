<?php

namespace Abather\MiniAccounting;

interface Referencable
{
    public function accountMovements();

    public function defaultTransactions();

    public function transactions();

    public function deposit();

    public function withdraw();
    public function getDepositAttribute();
    public function getBalanceAttribute();
    public function getWithdrawAttribute();
}
