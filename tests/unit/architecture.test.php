<?php

declare(strict_types=1);

namespace Tests\unit;

test('globals')
    ->expect(['dd', 'dump'])
    ->not->toBeUsed();
