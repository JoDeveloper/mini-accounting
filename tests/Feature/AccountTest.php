<?php

namespace Abather\MiniAccounting\Tests\Feature;

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

    public function test_user_balance_is_zero_when_no_transaction()
    {
        $user = User::factory()->create();
        $this->assertTrue($user->balance == 0);
    }

    public function test_user_balance_with_its_deposit_and_withdraw()
    {
        $user = User::factory()->create();

        foreach (range(1, 10) as $i) {
            $bill = new Bill();
            $bill->amount = random_int(100, 999);
            $user->bills()->save($bill);
            $user->withdraw("new withdraw", $bill->amount, $bill);
        }

        foreach (range(1, 10) as $i) {
            $refund = new Refund();
            $refund->amount = random_int(100, 999);
            $user->refunds()->save($refund);
            $user->deposit("new deposit", $refund->amount, $refund);
        }

        $deposit = $user->depositAccountMovements()->sum("amount");
        $withdraw = $user->withdrawAccountMovements()->sum("amount");

        $this->assertTrue($user->balance == ($deposit - $withdraw));
    }
}
