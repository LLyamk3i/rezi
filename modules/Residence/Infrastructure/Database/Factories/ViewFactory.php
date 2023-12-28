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
     * @return array<string,string>
     */
    public function definition(): array
    {
        return [
            'id' => Ulid::generate(),
            'device' => sprintf('%s/%s', fake()->userName(), Ulid::generate()),
            'residence_id' => Ulid::generate(),
        ];
    }
}
