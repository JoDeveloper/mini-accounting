<?php

namespace Abather\MiniAccounting\Commands;

use Illuminate\Console\Command;

class MiniAccountingCommand extends Command
{
    public $signature = 'mini-accounting';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
