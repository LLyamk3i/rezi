<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Helpers;

use Illuminate\Support\Facades\Artisan;
use Modules\Residence\Domain\ValueObjects\Location;
use Modules\Residence\Infrastructure\Models\Residence;

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
        ->location(value: new Location(...[$latitude, $longitude]))
        ->make()
        ->getAttributes();
}

/**
 * @phpstan-param mixed ...$vars
 */
function api_dd(...$vars): void
{
    var_dump(value: $vars);
    exit;
}
