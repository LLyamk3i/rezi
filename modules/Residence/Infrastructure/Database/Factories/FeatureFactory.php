<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Database\Factories;

use Symfony\Component\Uid\Ulid;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Residence\Infrastructure\Models\Feature;

/**
 * @extends Factory<Feature>
 *
 * @phpstan-type FeatureFactoryResponse array{id:string,name:string,created_at:string,updated_at:string}
 */
final class FeatureFactory extends Factory
{
    protected $model = Feature::class;

    /**
     * @phpstan-return FeatureFactoryResponse
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
