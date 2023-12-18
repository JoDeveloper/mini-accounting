<?php

namespace Abather\MiniAccounting\Objects\Calculations\Factors;

class VariableFactor extends Factor
{
    protected $resource;
    protected $variable;

    public function __construct()
    {
        Parent::__construct(Parent::TYPE_VARIABLE);
    }

    public function resource($resource, $variable): self
    {
        $this->resource = $resource;
        $this->variable = $variable;
        return $this;
    }

    public static function make(): self
    {
        return new self();
    }

    public function factor(): float
    {
        return $this->resource->{$this->variable};
    }
}
