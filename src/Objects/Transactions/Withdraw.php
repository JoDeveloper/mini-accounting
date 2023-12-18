<?php

namespace Abather\MiniAccounting\Objects\Transactions;

class Withdraw extends Transaction
{
    public function __construct($type, $description)
    {
        parent::__construct("withdraw", $description);
    }
}