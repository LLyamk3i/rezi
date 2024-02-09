<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Database\Factories;

use Symfony\Component\Uid\Ulid;
use Modules\Residence\Infrastructure\Models\View;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<View>
 */
final class ViewFactory extends Factory
{
    protected $model = View::class;

    /**
     * @return array{id: string, device: string, residence_id: string}
     */
    public function definition(): array
    {
        return [
            'id' => Ulid::generate(),
            'device' => sprintf('%s/%s', 'linux', fake()->word()),
            'residence_id' => Ulid::generate(),
        ];
    }
}
