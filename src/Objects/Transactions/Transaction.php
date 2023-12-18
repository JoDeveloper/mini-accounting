<?php

namespace Abather\MiniAccounting\Objects\Transactions;

use Abather\MiniAccounting\Objects\Account;

class Transaction
{
    protected $type;
    protected $description;
    protected Account $account;

    public function __construct($type, $description)
    {
        $this->type = $type;
        $this->description = $description;
    }

    public function getType()
    {
        return $this->type;
    }


    public function setType($type): self
    {
        $this->type = $type;
        return $this;
    }


    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description): self
    {
        $this->description = $description;
        return $this;
    }

    public function setAccount(Account $account): self
    {
        $this->account = $account;
        return $this;
    }

    public static function make($type, $description): self
    {
        return new static($type, $description);
    }
}
