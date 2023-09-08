<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Database\Factories;

use Symfony\Component\Uid\Ulid;
use Modules\Residence\Infrastructure\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Type>
 *
 * @phpstan-type TypeFactoryResponse array{id:string,name:string,created_at:string,updated_at:string}
 */
final class TypeFactory extends Factory
{
    protected $model = Type::class;

    /**
     * @phpstan-return TypeFactoryResponse
     */
    public function definition(): array
    {
        return [
            'id' => Ulid::generate(),
            'name' => fake()->word(),
            'created_at' => (string) now(),
            'updated_at' => (string) now(),
        ];
    }
}
