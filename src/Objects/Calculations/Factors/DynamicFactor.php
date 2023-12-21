<?php

namespace Abather\MiniAccounting\Objects\Calculations\Factors;

class DynamicFactor extends Factor
{
    protected $resource;
    protected $attribute;

    public function __construct($resource, $attribute)
    {
        $this->resource($resource, $attribute);

        Parent::__construct(Parent::TYPE_DYNAMIC);
    }

    private function resource($resource, $attribute): self
    {
        $this->resource = $resource;
        $this->attribute = $attribute;
        return $this;
    }

    public static function make(...$parameters): self
    {
        if(count($parameters) !== 2) {
            throw new \Exception('Invalid parameters');
        }

        return new self(...$parameters);
    }

    public function factor(): float
    {
        return $this->resource->{$this->attribute};
    }
}
