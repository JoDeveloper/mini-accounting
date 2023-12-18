<?php

namespace Abather\MiniAccounting\Objects\Calculations\Factors;

class DynamicFactor extends Factor
{
    protected $resource;
    protected $attribute;

    public function __construct()
    {
        Parent::__construct(Parent::TYPE_DYNAMIC);
    }

    public function resource($resource, $attribute): self
    {
        $this->resource = $resource;
        $this->attribute = $attribute;
        return $this;
    }

    public static function make(): self
    {
        return new self();
    }

    public function factor(): float
    {
        return $this->resource->{$this->attribute};
    }
}
