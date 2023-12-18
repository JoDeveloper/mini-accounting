<?php

namespace Abather\MiniAccounting\Objects\Calculations;

class Addition extends Calculation
{
    public function __construct()
    {
        parent::__construct(self::TYPE_ADDITION);
    }

    public static function make(): self
    {
        return new self();
    }

    public function amount(): float
    {
        $amount = $this->resource->{$this->variable};
        return $amount + $this->factor->factor();
    }
}
