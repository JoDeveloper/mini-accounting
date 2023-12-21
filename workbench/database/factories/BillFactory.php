<?php

namespace Workbench\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Workbench\App\Models\Bill;
use Workbench\App\Models\System;
use Workbench\App\Models\User;

/**
 * @template TModel of \Workbench\App\Bill
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class BillFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = Bill::class;

    public function definition($user_id = null, $system_id = null): array
    {
        return [
            'user_id' => $user_id ?? (User::factory()->create())->id,
            'system_id' => $system_id ?? (System::factory()->create())->id,
            'amount' => random_int(10000, 999999) / 100,
        ];
    }
}
