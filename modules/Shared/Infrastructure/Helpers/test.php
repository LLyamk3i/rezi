<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Illuminate\Database\Events\QueryExecuted;
use Symfony\Component\Uid\Ulid as SymphonyUlid;
use Modules\Authentication\Domain\Entities\User;
use Modules\Residence\Domain\ValueObjects\Location;
use Modules\Residence\Infrastructure\Models\Residence;
use Modules\Authentication\Infrastructure\Eloquent\Repositories\EloquentAccountRepository;

function listen_queries(): void
{
    $trace = debug_backtrace(options: \DEBUG_BACKTRACE_IGNORE_ARGS, limit: 1);
    if (isset($trace[0]['file']) && isset($trace[0]['line'])) {
        dump(vars: sprintf('listening on %s:%d', $trace[0]['file'], $trace[0]['line']) . \PHP_EOL);
    }

    DB::listen(static function (QueryExecuted $query): void {
        dump(vars: ['query' => $query->sql, 'bindings' => $query->bindings]);
    });
}

/**
 * @throws \RuntimeException
 */
function migrate_authentication(): void
{
    Artisan::call(
        command: 'migrate',
        parameters: ['--path' => 'modules/Authentication/Infrastructure/Database/Migrations']
    );
}

/**
 * @return array{}
 */
function residence_factory(float $latitude, float $longitude): array
{
    return Residence::factory()
        ->location(value: new Location(latitude: $latitude, longitude: $longitude))
        ->visible()
        ->make()
        ->getAttributes();
}

/**
 * @phpstan-param mixed ...$vars
 */
function api_dd(...$vars): never
{
    var_dump(value: $vars);
    exit;
}

function account_repository(): EloquentAccountRepository
{
    return resolve(name: EloquentAccountRepository::class);
}

/**
 * @throws \Modules\Shared\Domain\Exceptions\InvalidValueObjectException
 */
function user_entity_factory(): User
{
    return new User(
        id: new Ulid(value: SymphonyUlid::generate()),
        forename: 'test',
        surname: 'test',
        phone: fake()->phoneNumber(),
        email: 'test@test.com',
        password: 'test',
    );
}
