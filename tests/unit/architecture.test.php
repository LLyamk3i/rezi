<?php

declare(strict_types=1);

namespace Tests\unit;

test('globals')
    ->skip()
    ->expect(['dd', 'dump'])
    ->not->toBeUsed();
test('facades')
    ->skip()
    ->expect('Illuminate\Support\Facades')
    ->not->toBeUsed()
    ->ignoring('App\Providers')
    ->ignoring('Modules\**\Providers');
