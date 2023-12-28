<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Database\Factories;

use Symfony\Component\Uid\Ulid;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Residence\Infrastructure\Models\Favorite;

/**
 * @extends Factory<Favorite>
 */
final class FavoriteFactory extends Factory
{
    protected $model = Favorite::class;

    /**
     * @return array<string,mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Ulid::generate(),
            'user_id' => Ulid::generate(),
            'residence_id' => Ulid::generate(),
        ];
    }
}
