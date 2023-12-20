<?php

namespace Abather\MiniAccounting\Tests\Feature;

use Orchestra\Testbench\TestCase;
use Workbench\App\Models\Bill;
use Workbench\App\Models\User;

class CreateDepositToAccountTest extends TestCase
{
    public function test_create_deposit_to_account_successful()
    {
        $user = User::factory()->create();
        $bill = new Bill();
        $bill->amount = 100;
        $user->bills()->save($bill);

        $user->deposit("new deposit", $bill->amount, $bill);

        $this->assertTrue($user->balance == 100);
    }

    public function test_create_withdraw_to_account_successful()
    {
        $user = User::factory()->create();
        $bill = new Bill();
        $bill->amount = 100;
        $user->bills()->save($bill);

        $user->withdraw("new deposit", $bill->amount, $bill);

        $this->assertTrue($user->balance == -100);
    }
}
