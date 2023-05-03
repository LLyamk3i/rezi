<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Database\Factories;

use Symfony\Component\Uid\Ulid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Residence\Domain\ValueObjects\Location;
use Modules\Residence\Infrastructure\Models\Residence;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Residence\Infrastructure\Models\Residence>
 */
final class ResidenceFactory extends Factory
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
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function location(Location $value): self
    {
        return $this->state(state: [
            'location' => DB::raw("ST_PointFromText('POINT({$value->longitude} {$value->latitude})')"),
        ]);
    }

    public function id(string $value): self
    {
        return $this->state(state: [
            'id' => $value,
        ]);
    }
}
