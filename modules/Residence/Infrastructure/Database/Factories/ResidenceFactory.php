<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Database\Factories;

use Symfony\Component\Uid\Ulid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Residence\Domain\ValueObjects\Location;
use Modules\Residence\Infrastructure\Models\Residence;

use function Modules\Shared\Infrastructure\Helpers\timer;
use function Modules\Shared\Infrastructure\Helpers\integer_value;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Residence\Infrastructure\Models\Residence>
 */
class ResidenceFactory extends Factory
{
    /**
     * @var class-string<\Modules\Residence\Infrastructure\Models\Residence>
     */
    protected $model = Residence::class;

    /**
     * @return array{id:string,name:string,address:string,created_at:\Illuminate\Support\Carbon,updated_at:\Illuminate\Support\Carbon}
     */
    public function definition(): array
    {
        return [
            'id' => Ulid::generate(),
            'name' => fake()->streetAddress(),
            'address' => fake()->address(),
            'location' => DB::raw("ST_PointFromText('POINT(48.864716 2.349014)')"),
            'rent' => random_int(min: 15_000, max: 1_000_000),
            'description' => fake()->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function location(Location $value): self
    {
        return $this->state(state: ['location' => DB::raw("ST_PointFromText('POINT({$value->longitude} {$value->latitude})')")]);
    }

    public function id(string $value): self
    {
        return $this->state(state: ['id' => $value]);
    }

    /**
     * data to use in each seeds row
     *
     * @param array<int,array<string,string|float|int>> $data
     */
    public function template(array $data): self
    {
        $timer = timer();
        $timer->start(counter: integer_value(value: $this->count ?? 0));

        return $this->state(state: function () use ($timer, $data): array {
            $timer->decrease();

            return $data[$timer->loop() - 1] ?? [];
        });
    }
}
