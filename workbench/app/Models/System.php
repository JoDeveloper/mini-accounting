<?php

namespace Workbench\App\Models;

use Abather\MiniAccounting\Traits\HasAccountMovement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Workbench\Database\Factories\SystemFactory;

class System extends Model
{
    use HasFactory, HasAccountMovement;

    protected static function newFactory()
    {
        return SystemFactory::new();
    }
}
