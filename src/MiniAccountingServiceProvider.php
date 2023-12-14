<?php

namespace Abather\MiniAccounting;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Abather\MiniAccounting\Commands\MiniAccountingCommand;

class MiniAccountingServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('mini-accounting')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_mini-accounting_table')
            ->hasCommand(MiniAccountingCommand::class);
    }
}
