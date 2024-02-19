<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Database\Factories;

use Symfony\Component\Uid\Ulid;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Residence\Infrastructure\Models\Rating;
use Modules\Residence\Infrastructure\Models\Residence;

use function Modules\Shared\Infrastructure\Helpers\timer;
use function Modules\Shared\Infrastructure\Helpers\integer_value;

/**
 * @extends Factory<Rating>
 */
final class RatingFactory extends Factory
{
    protected $model = Rating::class;

    /**
     * @return array{id:string,value:int,user_id:string,residence_id:string,comment:string,created_at:string,updated_at:string}
     *
     * @throws \Random\RandomException
     */
    public function definition(): array
    {
        return [
            'id' => Ulid::generate(),
            'value' => random_int(min: 0, max: 5),
            'user_id' => Ulid::generate(),
            'residence_id' => Ulid::generate(),
            'comment' => fake()->paragraph(),
            'created_at' => (string) now(),
            'updated_at' => (string) now(),
        ];
    }

    /**
     * @param callable(string $id):string $value
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function clients(callable $value): self
    {
        $timer = timer()->init(counter: integer_value(value: $this->count));

        return $this->state(state: fn (array $_, Residence $residence): array => [
            'user_id' => $value($residence->getAttribute(key: 'user_id'), $timer->decrease()),
        ]);
    }

    public function residence(string $value): self
    {
        return $this->state(state: ['residence_id' => $value]);
    }
}
