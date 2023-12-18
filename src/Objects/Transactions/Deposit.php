<?php

namespace Abather\MiniAccounting\Objects\Transactions;

class Deposit extends Transaction
{
    public function __construct($resource, $description)
    {
        parent::__construct("deposit", $resource, $description);
    }

    public static function make($resource, $description): self
    {
        return new static($resource, $description);
    }
}
