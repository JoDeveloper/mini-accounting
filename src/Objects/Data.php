<?php

namespace Abather\MiniAccounting\Objects;

use Illuminate\Support\Collection;

class Data
{
    protected $resource;
    protected $attribute;

    public function __construct($resource, $attribute)
    {
        $this->resource = $resource;
        $this->attribute = $attribute;
    }

    public static function make($resource, $attribute)
    {
        return new self($resource, $attribute);
    }

    public function toArray(): array
    {
        $data = $this->resource->{$this->attribute};

        if (blank($data)) {
            return [];
        }

        if ($data instanceof Collection) {
            $data = $data->toArray();
        }

        if (!($data instanceof Countable || is_array($data))) {
            $data = [$data];
        }

        return $data;
    }
}
