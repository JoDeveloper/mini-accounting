<?php

namespace Abather\MiniAccounting\Objects;

class Deposit extends Transaction
{
    public function __construct($type, $description)
    {
        parent::__construct("deposit", $description);
    }
}
