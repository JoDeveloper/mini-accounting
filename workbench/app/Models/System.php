<?php

namespace Workbench\App\Models;

use Abather\MiniAccounting\Traits\HasAccountMovement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    use HasFactory, HasAccountMovement;
}
