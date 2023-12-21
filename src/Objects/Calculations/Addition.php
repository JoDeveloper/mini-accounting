<?php

namespace Abather\MiniAccounting\Objects\Calculations;

class Addition extends Calculation
{
    public function __construct()
    {
        parent::__construct(self::TYPE_ADDITION);
    }

    public static function make($resource, $attribute): \Abather\MiniAccounting\Objects\Calculations\Calculation
    {
        return (new self())->resource($resource, $attribute);
    }

    public function amount(): float
    {
        $amount = $this->resource->{$this->attribute};
        return $amount + $this->factor->factor();
    }
}
