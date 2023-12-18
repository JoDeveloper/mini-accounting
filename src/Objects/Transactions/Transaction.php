<?php

namespace Abather\MiniAccounting\Objects\Transactions;

use Abather\MiniAccounting\Objects\Account;
use Abather\MiniAccounting\Objects\Calculations\Calculation;

class Transaction
{
    protected $type;
    protected $description;
    protected Account $account;
    protected Calculation $calculation;

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

    public function getAccount(): Account
    {
        return $this->account;
    }

    public function setCalculation(Calculation $calculation): self
    {
        $this->calculation = $calculation;
        return $this;
    }

    public static function make($type, $description): self
    {
        return new static($type, $description);
    }

    public function generateAccountTransaction(): bool
    {
        if (blank($this->account->getResource())) {
            $this->account->setResource();
        }

        $model = $this->account->getResource();

        return $model->{$this->getType()}(
            $this->getDescription(),
            $this->calculation->amount(),
            $this->account->getCaller()
        );
    }
}
