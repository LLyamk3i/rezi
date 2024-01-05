<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Database\Factories;

use Symfony\Component\Uid\Ulid;
use Illuminate\Support\Facades\DB;
use Modules\Reservation\Domain\Enums\Status;
use Modules\Residence\Infrastructure\Models\Type;
use Modules\Residence\Infrastructure\Models\View;
use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Residence\Domain\ValueObjects\Distance;
use Modules\Residence\Domain\ValueObjects\Location;
use Modules\Residence\Infrastructure\Models\Feature;
use Modules\Residence\Infrastructure\Models\Favorite;
use Modules\Authentication\Infrastructure\Models\User;
use Modules\Residence\Infrastructure\Models\Residence;
use Modules\Reservation\Infrastructure\Models\Reservation;
use Modules\Residence\Application\Services\Location\RandomPositionGeneratorService;

use function Modules\Shared\Infrastructure\Helpers\can_use_spatial_index;

/**
 * @extends Factory<Residence>
 *
 * @phpstan-type ResidenceFactoryResponse array{id:string,name:string,address:string,location?:\Illuminate\Contracts\Database\Query\Expression,rent:int<15000,1000000>,description:string,visible:int<0,1>,rooms:int<1,6>,created_at:string,updated_at:string}
 */
final class ResidenceFactory extends Factory
{
    use ResidenceFactoryStates\MediaStates;
    use ResidenceFactoryStates\RatingStates;
    use ResidenceFactoryStates\ResidenceStates;

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
                radius: new Distance(value: 396.23),
                location: new Location(latitude: 7.662327159867307, longitude: -5.571228414825439),
            );
        }

        $coordinates = $this->service->execute();

        return [
            'id' => Ulid::generate(),
            'name' => fake()->streetAddress(),
            'address' => fake()->address(),
            'location' => $this->coordinates(value: $coordinates),
            'rent' => random_int(min: 15_000, max: 1_000_000),
            'description' => fake()->sentence(),
            'visible' => random_int(min: 0, max: 1),
            'rooms' => random_int(min: 1, max: 6),
            'user_id' => Ulid::generate(),
            'type_id' => Ulid::generate(),
            'created_at' => (string) now(),
            'updated_at' => (string) now(),
        ];
    }

    public function owner(): self
    {
        return $this->state(state: ['user_id' => User::factory()->avatar()]);
    }

    public function favoured(User $client): self
    {
        return $this->has(
            relationship: 'favorites',
            factory: Favorite::factory()->state(state: ['user_id' => $client]),
        );
    }

    public function views(int $count): self
    {
        return $this->has(
            relationship: 'views',
            factory: View::factory()->count(count: $count),
        );
    }

    public function reservations(int $count, bool $confirmed = false): self
    {
        $factory = Reservation::factory()->count(count: $count);
        if ($confirmed) {
            $factory->state(state: ['status' => Status::CONFIRMED->value]);
        }

        return $this->has(relationship: 'reservations', factory: $factory);
    }

    public function features(int $count): self
    {
        return $this->has(
            relationship: 'features',
            factory: Feature::factory()->icon()->count(count: $count),
        );
    }

    public function type(string $name): self
    {
        return $this->for(
            relationship: 'type',
            factory: Type::factory()->state(state: ['name' => $name]),
        );
    }

    /**
     * @param array{latitude:float,longitude:float} $value
     */
    private function coordinates(array $value): null | Expression
    {
        if (can_use_spatial_index()) {
            return DB::raw(value: "ST_PointFromText('POINT({$value['latitude']} {$value['longitude']})')");
        }

        return null;
    }
}
