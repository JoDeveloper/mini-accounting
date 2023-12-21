<?php

namespace Abather\MiniAccounting\Objects\Calculations\Factors;

class StaticFactor extends Factor
{
    protected $value;

    public function __construct($value)
    {
        $this->value($value);
        Parent::__construct(Parent::TYPE_STATIC);
    }

    private function value($value): self
    {
        $this->value = $value;
        return $this;
    }

    public static function make(...$parameters): self
    {
        if(count($parameters) !== 1) {
            throw new \Exception('Invalid parameters');
        }
        return new self(...$parameters);
    }

    public function factor(): float
    {
        return $this->value;
    }
}
