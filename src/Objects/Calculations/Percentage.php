<?php

namespace Abather\MiniAccounting\Objects\Calculations;

class Percentage extends Calculation
{

    public function __construct()
    {
        parent::__construct(self::TYPE_PERCENTAGE);
    }

    public static function make(): self
    {
        return new self();
    }

    public function amount(): float
    {
        $amount = $this->resource->{$this->attribute};
        $amount = $amount / 100;
        return $amount * $this->factor->factor();
    }
}
