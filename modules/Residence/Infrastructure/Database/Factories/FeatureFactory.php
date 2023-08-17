<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Residence\Infrastructure\Models\Feature;

/**
 * @extends Factory<Feature>
 */
final class FeatureFactory extends Factory
{
    protected $model = Feature::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
        ];
    }
}
