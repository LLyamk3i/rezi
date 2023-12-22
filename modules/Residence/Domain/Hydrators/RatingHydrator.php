<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\Hydrators;

use Illuminate\Support\Arr;
use Modules\Residence\Domain\Entities\Rating;
use Modules\Residence\Domain\Factories\OwnerFactory;
use Modules\Residence\Domain\Factories\RatingFactory;
use Modules\Shared\Domain\Contracts\HydratorContract;

use function Modules\Shared\Infrastructure\Helpers\array_pull_and_exclude;

/**
 * @phpstan-import-type RatingRecord from \Modules\Residence\Domain\Factories\RatingFactory
 *
 * @implements HydratorContract<RatingRecord,Rating>
 */
final readonly class RatingHydrator implements HydratorContract
{
    public function __construct(
        private RatingFactory $rating,
        private OwnerFactory $owner,
    ) {
        //
    }

    /**
     * @phpstan-param array<int,RatingRecord> $data
     *
     * @return array<int,Rating>
     */
    public function hydrate(array $data): array
    {
        return Arr::map(
            array: $data,
            callback: function (array $row): Rating {
                $owner = $this->owner->make(data: array_pull_and_exclude(original: $row, keys: ['owner_id', 'owner_surname', 'owner_forename']));

                return $this->rating->make(data: [...$row, 'owner' => $owner]);
            },
        );
    }
}
