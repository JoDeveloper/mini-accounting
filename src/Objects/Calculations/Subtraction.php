<?php

namespace Abather\MiniAccounting\Objects\Calculations;

class Subtraction extends Calculation
{
    public function __construct()
    {
        parent::__construct(self::TYPE_SUBTRACTION);
    }

    public static function make(): \Abather\MiniAccounting\Objects\Calculations\Calculation
    {
        return new self();
    }

    public function amount(): float
    {
        $amount = $this->resource->{$this->variable};
        return $amount - $this->factor->factor();
    }
}
