<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Database\Factories\ResidenceFactoryStates;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Modules\Residence\Infrastructure\Models\Rating;
use Modules\Authentication\Infrastructure\Models\User;

trait RatingStates
{
    public function ratings(int $count): self
    {
        $closure = static function (string $owner, int $time) use ($count): string {
            $list = Cache::remember(key: 'residence.rating', ttl: 60 * 5, callback: function () use ($count, $owner): array {
                $result = DB::table(table: 'users')
                    ->where(column: 'id', operator: '!=', value: $owner)
                    ->limit(value: $count)
                    ->pluck(column: 'id');

                $factory = static fn (int $count): \Illuminate\Support\Collection => User::factory()
                    ->count(count: abs(num: $count))
                    ->avatar()
                    ->create()
                    ->pluck(value: 'id');

                $diff = $result->count() - $count;

                return $diff < 0 ? [...$result, ...$factory($diff)] : $result->toArray();
            });

            $result = $list[$time];

            throw_if(condition: ! \is_string(value: $result));

            return $result;
        };

        return $this->has(
            relationship: 'ratings',
            factory: Rating::factory()->count(count: $count)->clients(value: $closure),
        );
    }
}
