<?php

namespace Abather\MiniAccounting\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class MoneyCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $value / pow(10, config("mini-accounting.currency_precision"));
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        $value = round($value, config("mini-accounting.currency_precision"));
        return $value * pow(10, config("mini-accounting.currency_precision"));
    }
}
