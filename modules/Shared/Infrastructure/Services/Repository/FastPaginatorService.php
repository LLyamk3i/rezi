<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Services\Repository;

use Illuminate\Support\Facades\DB;

final class FastPaginatorService
{
    public function run(int $page = 1): mixed
    {
        $ids = DB::table(table: 'residences')
            ->limit(value: 15)
            ->offset(value: 0)
            ->get(columns: ['id']);

        return [
            'items' => DB::table(table: 'residences')->whereIn('id', $ids)->get(),
            'total' => DB::table(table: 'residences')->count(),
        ];
    }
}
