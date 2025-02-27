<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Factories;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Modules\Residence\Domain\Enums\Media;
use Modules\Residence\Infrastructure\Models\Residence;

final class ResidenceQueryFactory
{
    public function make(): Builder
    {
        return DB::table(table: 'residences')
            ->where(column: 'visible', operator: '=', value: 1)
            ->leftJoin(table: 'users', first: 'residences.user_id', operator: '=', second: 'users.id')
            ->leftJoin(table: 'media', first: static function (JoinClause $join): void {
                $join->on(first: 'media.fileable_id', operator: '=', second: 'residences.id')
                    ->where(column: 'media.fileable_type', operator: '=', value: (new Residence())->getMorphClass())
                    ->where(column: 'media.type', operator: '=', value: Media::Poster->value);
            });
    }
}
