<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Database\Factories\ResidenceFactoryStates;

use Illuminate\Support\Facades\DB;
use Modules\Residence\Domain\ValueObjects\Location;

use function Modules\Shared\Infrastructure\Helpers\timer;
use function Modules\Shared\Infrastructure\Helpers\using_sqlite;
use function Modules\Shared\Infrastructure\Helpers\integer_value;

trait ResidenceStates
{
    public function invisible(): self
    {
        return $this->state(state: ['visible' => false]);
    }

    public function visible(): self
    {
        return $this->state(state: ['visible' => true]);
    }

    public function unlocated(): self
    {
        return $this->state(state: ['location' => null]);
    }

    public function location(Location $value): self
    {
        if (using_sqlite()) {
            return $this;
        }

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
        $timer->init(counter: integer_value(value: $this->count ?? 0));

        return $this->state(state: function () use ($timer, $data): array {
            $timer->decrease();

            return $data[$timer->loop() - 1] ?? [];
        });
    }
}
