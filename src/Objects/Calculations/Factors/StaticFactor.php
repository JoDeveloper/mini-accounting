<?php

namespace Abather\MiniAccounting\Objects\Calculations\Factors;

class StaticFactor extends Factor
{
    protected $value;

    public function __construct()
    {
        Parent::__construct(Parent::TYPE_STATIC);
    }

    public function value($value): self
    {
        $this->value = $value;
        return $this;
    }

    public static function make(): self
    {
        return new self();
    }

    public function factor(): float
    {
        return $this->value;
    }
}
