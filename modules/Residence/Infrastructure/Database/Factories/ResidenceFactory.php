<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Database\Factories;

use Symfony\Component\Uid\Ulid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Residence\Domain\ValueObjects\Distance;
use Modules\Residence\Domain\ValueObjects\Location;

use Modules\Residence\Infrastructure\Models\Residence;

use function Modules\Shared\Infrastructure\Helpers\timer;
use function Modules\Shared\Infrastructure\Helpers\integer_value;

use Modules\Residence\Application\Services\Location\RandomPositionGeneratorService;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Residence\Infrastructure\Models\Residence>
 *
 * @phpstan-type ResidenceFactoryResponse array{id:string,name:string,address:string,location:\Illuminate\Contracts\Database\Query\Expression,rent:int<15000,1000000>,description:string,visible:int<0,1>,rooms:int<1,6>,created_at:string,updated_at:string}
 */
final class ResidenceFactory extends Factory
{
    /**
     * @var class-string<\Modules\Residence\Infrastructure\Models\Residence>
     */
    protected $model = Residence::class;

    private ?RandomPositionGeneratorService $service = null;

    /**
     * @phpstan-return ResidenceFactoryResponse
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

        return [
            'id' => Ulid::generate(),
            'name' => fake()->streetAddress(),
            'address' => fake()->address(),
            'location' => DB::raw("ST_PointFromText('POINT({$coordinates['latitude']} {$coordinates['longitude']})')"),
            'rent' => random_int(min: 15_000, max: 1_000_000),
            'description' => fake()->sentence(),
            'visible' => rand(min: 0, max: 1),
            'rooms' => rand(min: 1, max: 6),
            'created_at' => (string) now(),
            'updated_at' => (string) now(),
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
