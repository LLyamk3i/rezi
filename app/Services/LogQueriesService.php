<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Events\QueryExecuted;

final class LogQueriesService
{
    private const IGNORES = [
        'sqlite_master',
        'migrations',
        'languages',
        // 'create',
        'PRAGMA',
        'where "slug" like',
    ];

    public static function handle(): void
    {
        // File::delete(paths: storage_path(path: '/logs/queries.log'));
        DB::listen(callback: static function (QueryExecuted $query): void {
            if (Str::contains(haystack: $query->sql, needles: self::IGNORES)) {
                return;
            }

            Log::channel(channel: 'query')->info(
                message: $query->sql,
                context: [
                    'bindings' => $query->bindings,
                    'time' => $query->time,
                ]
            );
        });
    }
}
