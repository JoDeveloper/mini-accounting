<?php

namespace Abather\MiniAccounting\Tests\Feature;

use Orchestra\Testbench\TestCase;
use Workbench\App\Models\Bill;

class ReferenceTest extends TestCase
{
    public function test_execute_default_transactions()
    {
        $bill = Bill::factory()->create();
        $bill->executeDefaultTransactions();
        $bill->refresh();
        $this->assertTrue($bill->accountMovements()->count() == count($bill->defaultTransactions()));
    }

    public function test_execute_costume_transactions()
    {
        $bill = Bill::factory()->create();
        $bill->executeCancelTransactions();
        $bill->refresh();
        $this->assertTrue($bill->accountMovements()->count() == count($bill->cancelTransactions()));
    }

    public function test_execute_many_transactions_groups()
    {
        $bill = Bill::factory()->create();
        $bill->executeCancelTransactions();
        $bill->executeDefaultTransactions();
        $bill->refresh();
        $this->assertTrue($bill->accountMovements()->count() == (count($bill->cancelTransactions()) + count($bill->defaultTransactions())));
    }

    public function test_amount_assigned_to_an_account_from_transactions()
    {
        $bill = Bill::factory()->create();
        $bill->executeCancelTransactions();
        $bill->refresh();
        $user = $bill->user;
        $this->assertTrue($bill->amount == $user->lastAccountMovement->amount);
    }

    public function test_transactions_with_data_defined()
    {
        $bill = Bill::factory()->create();
        $bill->data = [
            "test" => "test value",
            "test2" => "test value 2"
        ];

        $bill->save();

        $bill->executeWithDataTransactions();
        $bill->refresh();

        $user = $bill->user;
        $transaction = $user->lastAccountMovement;

        $this->assertTrue($bill->data === $transaction->data);
    }

    public function test_transactions_with_collection_data_defined()
    {
        $bill = Bill::factory()->create();

        $bill->save();

        $bill->executeWithCollectionDataTransactions();
        $bill->refresh();

        $user = $bill->user;
        $transaction = $user->lastAccountMovement;

        $this->assertIsArray($transaction->data);
        $this->assertTrue(count($transaction->data) > 0);
    }
}
