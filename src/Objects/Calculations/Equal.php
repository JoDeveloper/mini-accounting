<?php

namespace Abather\MiniAccounting\Objects\Calculations;

class Equal extends Calculation
{
    public function __construct()
    {
        parent::__construct(self::TYPE_EQUAL);
    }

    public static function make(): self
    {
        return new self();
    }

    public function amount(): float
    {
        return $this->resource->{$this->attribute};
    }
}
