<?php

namespace Abather\MiniAccounting\Objects\Calculations;

class Equal extends Calculation
{
    public function __construct()
    {
        parent::__construct(self::TYPE_EQUAL);
    }

    public static function make($resource, $attribute): \Abather\MiniAccounting\Objects\Calculations\Calculation
    {
        return (new self())->resource($resource, $attribute);
    }

    public function amount(): float
    {
        return $this->resource->{$this->attribute};
    }
}
