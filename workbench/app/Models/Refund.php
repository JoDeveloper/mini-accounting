<?php

namespace Workbench\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Abather\MiniAccounting\Contracts\Referencable;

class Refund extends Model implements Referencable
{
    use \Abather\MiniAccounting\Traits\Referencable;
    use HasFactory;

    public function defaultTransactions(): array
    {
        return [];
    }
}
