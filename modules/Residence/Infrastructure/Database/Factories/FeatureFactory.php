<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Database\Factories;

use Symfony\Component\Uid\Ulid;
use Modules\Shared\Infrastructure\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Residence\Infrastructure\Models\Feature;
use Modules\Residence\Domain\Enums\Media as EnumsMedia;

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

    public function icon(): self
    {
        return $this->has(
            relationship: 'icon',
            factory: Media::factory()->type(value: EnumsMedia::Icon->value),
        );
    }
}
