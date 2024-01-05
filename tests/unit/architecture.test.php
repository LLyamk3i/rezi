<?php

declare(strict_types=1);

namespace Tests\unit;

test(description: 'globals')
    ->skip()
    ->expect(value: ['dd', 'dump', 'listen_queries'])
    ->not->toBeUsed();
