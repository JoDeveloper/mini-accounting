<?php

namespace Abather\MiniAccounting\Objects\Transactions;

class Withdraw extends Transaction
{
    public function __construct($resource, $description)
    {
        parent::__construct("withdraw", $resource, $description);
    }

    public static function make($resource, $description): self
    {
        return new static($resource, $description);
    }
}
