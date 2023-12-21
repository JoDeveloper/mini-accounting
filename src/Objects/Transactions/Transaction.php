<?php

namespace Abather\MiniAccounting\Objects\Transactions;

use Abather\MiniAccounting\Objects\Account;
use Abather\MiniAccounting\Objects\Calculations\Calculation;

abstract class Transaction
{
    protected $type;
    protected $description;
    protected $resource;
    protected Account $account;
    protected Calculation $calculation;

    public function __construct($type, $resource, $description)
    {
        $this->type = $type;
        $this->description = $description;
        $this->resource = $resource;
    }

    public function getResource()
    {
        return $this->resource;
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
        $this->account = $account->setCaller($this->resource);
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

    public function getCalculation(): Calculation
    {
        return $this->calculation;
    }

    abstract public static function make($resource, $description): self;

    public function generateAccountTransaction()
    {
        if (blank($this->account->getResource())) {
            $this->account->setResource();
        }

        return $this->getResource()->{$this->getType()}(
            $this->getDescription(),
            $this->calculation->amount(),
            $this->account->getResource()
        );
    }
}
