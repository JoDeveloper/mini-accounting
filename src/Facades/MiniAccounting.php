<?php

namespace Abather\MiniAccounting\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Abather\MiniAccounting\MiniAccounting
 */
class MiniAccounting extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Abather\MiniAccounting\MiniAccounting::class;
    }
}
