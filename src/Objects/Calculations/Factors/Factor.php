<?php

namespace Abather\MiniAccounting\Objects\Calculations\Factors;

abstract class Factor
{
    protected $type;
    const TYPE_STATIC = "static";
    const TYPE_DYNAMIC = "dynamic";

    public function __construct($type = self::TYPE_STATIC)
    {
        $this->type = $type;
    }

    abstract public static function make(): self;

    abstract public function factor(): float;
}
