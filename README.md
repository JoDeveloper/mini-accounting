# Create accounts for any model to withdraw and deposit to it.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/abather/mini-accounting.svg?style=flat-square)](https://packagist.org/packages/abather/mini-accounting)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/abather/mini-accounting/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/abather/mini-accounting/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/abather/mini-accounting/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/abather/mini-accounting/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/abather/mini-accounting.svg?style=flat-square)](https://packagist.org/packages/abather/mini-accounting)

Add Account to your models and follow each transaction that don on it. You can get Model current balance, or balance at
any given time.

## Installation

You can install the package via composer:

```bash
composer require abather/mini-accounting
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="mini-accounting-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="mini-accounting-config"
```

This is the contents of the published config file:

```php
return [
    "prevent_duplication" => true,
    "currency_precision" => 2
];
```

## Usage

the package is linked with two entties the first one is *Accountable* which is the model that has an account,
and the second one is *Referncable* which is the document that may cuse account deposit or withdraw.

### Accountable:

If you went any `Model` to be accountable that mean you can deposit or withdraw from this account you have to
use `HasAccountMovement` trait:

```php
<?php

namespace App\Models;

use Abather\MiniAccounting\Traits\HasAccountMovement;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    use HasAccountMovement;
    
    //your code
}
```

now you can `deposit` or `withdraw` any amount from it with refer to any `reference` model:

```php
$system->deposit("Description Of The transaction", 350, $bill);
```

you can provide any notes or extra data to any transaction as `JSON` by passing it to the `deposit` or `withdraw`
methods:

```php
$system->deposit("Description Of The transaction", 350, $bill, "Extra Notes", $json);
```

if you went to get `model` current balance:

```php
$system->balance
```

also you can get `model` balance at the end of any month:

```php
$system->balanceAtEndOfMonth("2023-10-01")
//This well return the system balance at the end of month 10
```

### Referencable

You can make any `model` as `referencable` by using `referencable` trait and implementing `referencable` interface:

```php
<?php

namespace App\Models;

use Abather\MiniAccounting\Contracts\Referencable;use Illuminate\Database\Eloquent\Factories\HasFactory;use Illuminate\Database\Eloquent\Model;

class Bill extends Model implements Referencable
{
    use \Abather\MiniAccounting\Traits\Referencable;
    use HasFactory;

    public function defaultTransactions(): array
    {
        return [];
    }
}

```

you must defined `defaultTransactions(): array` method we will describe its used later.
as the accountable `model` you can do `deposit` and `withdraw` to `referencable` with refer to `accountable` model.
the difference is the `referencable` affect different accounts at the same time, for example
if user buy from one market that mean the bill will `deposit` amount to `market` and `withdraw` the same amount
from `user`:

```php
$bill = Bill::first();
$bill->deposit("Deposit", $bill->amount, $bill->market);
$bill->withdraw("Withdraw", $bill->amount, $bill->user);
```

let asume that you have another transaction that may cused by `Bill` for example you have sit cumission
so your code will be:

```php
$bill = Bill::first();
$bill->deposit("Deposit", $bill->amount, $bill->market);
$bill->withdraw("Withdraw", $bill->amount, $bill->user);
$bill->withdraw("Withdraw", $bill->amount * 0.1, $bill->market);
$bill->deposit("Deposit", $bill->amount * 0.1, $system);
```

to make it easy you can defind the default transaction for each `referencable` model using `defaultTransactions` method:

```php
public function defaultTransactions(): array
    {
        return [];
    }
```

this method will return an array of `Abather\MiniAccounting\Objects\Transactions\Withdraw`
or `Abather\MiniAccounting\Objects\Transactions\Deposit` objects:

```php
    public function defaultTransactions(): array
    {
        return [
            Withdraw::make($this, "description")
                ->setAccount(Account::make(\App\Models\User::class)
                    ->relationship("user"))
                ->setCalculation(Equal::make()->resource($this, "amount")),

            Deposit::make($this, "any description")
                ->setAccount(Account::make(\App\Models\Market::class)
                    ->relationship("market"))
                ->setCalculation(Equal::make()->resource($this, "amount")),

            Withdraw::make($this, "other description")
                ->setAccount(Account::make(\App\Models\Market::class)
                    ->relationship("market"))
                ->setCalculation(Percentage::make()->resource($this, "amount")
                ->factor(StaticFactor::make()->value(10))),
                
            Deposit::make($this, "other description")
                ->setAccount(Account::make(\App\Models\System::class, System::first()))
                ->setCalculation(Percentage::make()->resource($this, "amount")
                ->factor(StaticFactor::make()->value(10))),
        ];
    }
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Abather](https://github.com/Abather)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
