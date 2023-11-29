<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Database\Factories;

use Symfony\Component\Uid\Ulid;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Residence\Domain\ValueObjects\Distance;
use Modules\Residence\Domain\ValueObjects\Location;
use Modules\Residence\Infrastructure\Models\Residence;
use Modules\Residence\Application\Services\Location\RandomPositionGeneratorService;

use function Modules\Shared\Infrastructure\Helpers\timer;
use function Modules\Shared\Infrastructure\Helpers\integer_value;
use function Modules\Shared\Infrastructure\Helpers\can_use_spatial_index;

/**
 * @extends Factory<Residence>
 *
 * @phpstan-type ResidenceFactoryResponse array{id:string,name:string,address:string,location?:\Illuminate\Contracts\Database\Query\Expression,rent:int<15000,1000000>,description:string,visible:int<0,1>,rooms:int<1,6>,created_at:string,updated_at:string}
 */
final class ResidenceFactory extends Factory
{
    /**
     * @var class-string<\Modules\Residence\Infrastructure\Models\Residence>
     */
    protected $model = Residence::class;

    private null | RandomPositionGeneratorService $service = null;

    /**
     * @phpstan-return ResidenceFactoryResponse
     *
     * @throws \Random\RandomException
     * @throws \InvalidArgumentException
     */
    public function definition(): array
    {
        if (\is_null(value: $this->service)) {
            $this->service = new RandomPositionGeneratorService(
                location: new Location(latitude: 7.662327159867307, longitude: -5.571228414825439),
                radius: new Distance(value: 396.23),
            );
        }

        $coordinates = $this->service->execute();

        return array_filter(
            array: [
                'id' => Ulid::generate(),
                'name' => fake()->streetAddress(),
                'address' => fake()->address(),
                'location' => $this->coordinates(value: $coordinates),
                'rent' => random_int(min: 15_000, max: 1_000_000),
                'description' => fake()->sentence(),
                'visible' => random_int(min: 0, max: 1),
                'rooms' => random_int(min: 1, max: 6),
                'created_at' => (string) now(),
                'updated_at' => (string) now(),
            ],
            callback: fn (mixed $value) => ! \is_null(value: $value),
        );
    }

    public function unlocated(): self
    {
        return $this->state(state: ['location' => null]);
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
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
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

    /**
     * @param array{latitude:float,longitude:float} $value
     */
    private function coordinates(array $value): null | Expression
    {
        return can_use_spatial_index()
            ? DB::raw("ST_PointFromText('POINT({$value['latitude']} {$value['longitude']})')")
            : null;
    }
}
