<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Helpers;

use Illuminate\Support\Facades\App;
use Modules\Shared\Application\Utils\Timer;

/**
 * @throws \RuntimeException
 */
function timer(): Timer
{
    return App::make(abstract: Timer::class);
}
