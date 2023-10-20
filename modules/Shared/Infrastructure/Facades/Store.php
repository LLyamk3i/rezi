<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Shared\Domain\Contracts\StoreContract;

final class Store extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return StoreContract::class;
    }
}
