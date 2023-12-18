<?php

namespace Abather\MiniAccounting\Objects\Calculations;

use Abather\MiniAccounting\Objects\Calculations\Factors\Factor;

abstract class Calculation
{
    protected $type;
    protected Factor $factor;
    protected $variable;
    protected $resource;
    const TYPE_EQUAL = 'equal';
    const TYPE_PERCENTAGE = 'percentage';
    const TYPE_SUBTRACTION = 'subtraction';
    const TYPE_ADDITION = 'addition';

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function resource($resource, $variable): self
    {
        $this->resource = $resource;
        $this->variable = $variable;
        return $this;
    }

    public function factor(Factor $factor): self
    {
        $this->factor = $factor;
        return $this;
    }

    abstract public static function make(): self;

    abstract public function amount(): float;
}
