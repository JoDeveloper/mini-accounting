<?php

namespace Abather\MiniAccounting\Tests\Feature;

use Illuminate\Log\Logger;
use Orchestra\Testbench\TestCase;
use Workbench\App\Models\Bill;
use Workbench\App\Models\Refund;
use Workbench\App\Models\User;

class AccountTest extends TestCase
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

        $user->withdraw("new withdraw", $bill->amount, $bill);

        $this->assertTrue($user->balance == -100);
    }

    public function test_create_withdraw_and_deposit_to_account_successful()
    {
        $user = User::factory()->create();
        $refund = new Refund();
        $refund->amount = 300;
        $user->refunds()->save($refund);

        $user->deposit("new deposit", $refund->amount, $refund);

        $bill = new Bill();
        $bill->amount = 100;
        $user->bills()->save($bill);

        $user->withdraw("new withdraw", $bill->amount, $bill);

        $this->assertTrue($user->balance == 200);
    }
}
