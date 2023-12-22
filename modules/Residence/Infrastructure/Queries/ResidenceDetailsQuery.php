<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Queries;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;
use Modules\Residence\Domain\Enums\Media;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Residence\Domain\Factories\TypeFactory;
use Modules\Residence\Domain\Factories\OwnerFactory;
use Modules\Residence\Infrastructure\Models\Feature;
use Modules\Authentication\Infrastructure\Models\User;
use Modules\Residence\Domain\Hydrators\RatingHydrator;
use Modules\Residence\Domain\Hydrators\FeatureHydrator;
use Modules\Shared\Application\Repositories\Repository;
use Modules\Residence\Domain\Factories\ResidenceFactory;
use Modules\Residence\Domain\Entities\Residence as Entity;
use Modules\Reservation\Domain\Hydrators\ReservationHydrator;
use Modules\Residence\Infrastructure\Factories\ColumnsFactory;

use Modules\Residence\Infrastructure\Models\Residence as Model;
use Modules\Residence\Infrastructure\Factories\ResidenceQueryFactory;

use function Modules\Shared\Infrastructure\Helpers\string_value;
use function Modules\Shared\Infrastructure\Helpers\array_pull_and_exclude;

final readonly class ResidenceDetailsQuery
{
    public function __construct(
        private ColumnsFactory $columns,
        private ResidenceQueryFactory $query,
        private Repository $repository,
        private ResidenceFactory $residence,
        private OwnerFactory $owner,
        private TypeFactory $type,
        private RatingHydrator $ratings,
        private ReservationHydrator $reservations,
        private FeatureHydrator $features,
    ) {
        //
    }

    public function run(Ulid $id): Entity | null
    {
        $residence = $this->repository->find(
            columns: [...$this->columns->make(), 'residences.rooms', 'types.id as type_id', 'types.name as type_name'],
            query: $this->query->make()
                ->where(column: 'residences.id', operator: '=', value: $id->value)
                ->leftJoin(table: 'types', first: 'residences.type_id', operator: '=', second: 'types.id')
        );

        if (! \is_array(value: $residence)) {
            return null;
        }

        $residence_id = string_value(value: $residence['id']);

        $residence = [...$residence,  'owner_avatar' => $this->avatar(owner: $residence_id)];

        $reviews = $this->reviews(residence: $residence_id);

        $owner = $this->owner->make(data: array_pull_and_exclude(
            original: $residence,
            keys: ['owner_avatar', 'owner_id', 'owner_forename', 'owner_surname']
        ));

        $type = $this->type->make(data: array_pull_and_exclude(original: $residence, keys: ['type_name', 'type_id']));

        return $this->residence->make(data: [
            ...$residence,
            'owner' => $owner,
            'type' => $type,
            'note' => $reviews['note'],
            'ratings' => $reviews['ratings'],
            'gallery' => $this->gallery(residence: $residence_id),
            'reservations' => $this->reservations(residence: $residence_id),
            'features' => $this->features(residence: $residence_id),
            'poster' => $residence['poster'],
        ]);
    }

    /**
     * Undocumented function
     *
     * @return array<int,\Modules\Residence\Domain\Entities\Feature>
     */
    private function features(string $residence): array
    {
        $sub = static fn () => DB::table(table: 'feature_residence')
            ->select(columns: ['feature_id'])
            ->where(column: 'residence_id', operator: '=', value: $residence);

        return $this->features->hydrate(
            data: DB::table(table: 'features')
                ->whereIn(column: 'features.id', values: $sub())
                ->leftJoin(table: 'media', first: static function (JoinClause $join): void {
                    $join->on(first: 'media.fileable_id', operator: '=', second: 'features.id')
                        ->where(column: 'media.fileable_type', operator: '=', value: (new Feature())->getMorphClass())
                        ->where(column: 'media.type', operator: '=', value: Media::Icon->value);
                })
                ->get(columns: ['features.id', 'features.name', 'media.path as icon'])
                ->toArray()
        );
    }

    private function reservations(string $residence): array
    {
        return $this->reservations->hydrate(
            data: DB::table(table: 'reservations')
                ->where(column: 'residence_id', operator: '=', value: $residence)
                ->get(columns: ['id', 'checkin_at', 'checkout_at'])
                ->toArray()
        );
    }

    private function reviews(string $residence): array
    {
        $ratings = DB::table(table: 'ratings')
            ->where(column: 'residence_id', operator: '=', value: $residence)
            ->leftJoin(table: 'users', first: 'ratings.user_id', operator: '=', second: 'users.id')
            ->get(columns: [
                'ratings.id',
                'ratings.value',
                'ratings.comment',
                'ratings.created_at',
                'users.id as owner_id',
                'users.surname as owner_surname',
                'users.forename as owner_forename',
            ]);

        return [
            'note' => $ratings->average(callback: 'value'),
            'ratings' => $this->ratings->hydrate(data: $ratings->toArray()),
        ];
    }

    private function avatar(string $owner): string | null
    {
        return DB::table(table: 'media')
            ->where(column: 'media.fileable_type', operator: '=', value: (new User())->getMorphClass())
            ->where(column: 'media.fileable_id', operator: '=', value: $owner)
            ->where(column: 'media.type', operator: '=', value: Media::Avatar->value)
            ->value(column: 'path');
    }

    private function gallery(string $residence): array
    {
        return DB::table(table: 'media')
            ->where(column: 'media.fileable_type', operator: '=', value: (new Model())->getMorphClass())
            ->where(column: 'media.fileable_id', operator: '=', value: $residence)
            ->where(column: 'media.type', operator: '=', value: Media::Gallery->value)
            ->pluck(column: 'path')
            ->map(callback: static fn (string $path) => route(name: 'image.show', parameters: ['path' => $path]))
            ->toArray();
    }
}
