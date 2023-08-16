<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Database\Factories;

use Modules\Residence\Infrastructure\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Type>
 */
final class TypeFactory extends Factory
{
    protected $model = Type::class;

    /**
     * @return array{name:string}
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
        ];
    }
}
