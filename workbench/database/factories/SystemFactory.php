<?php

namespace Workbench\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Workbench\App\Models\System;
use Workbench\App\Models\User;

/**
 * @template TModel of \Workbench\App\System
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class SystemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = System::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        ];
    }
}
