<?php

declare(strict_types=1);

namespace Tests;

abstract class SqliteTestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config()->set(key: 'database.default', value: 'sqlite');
        config()->set(key: 'database.connections.sqlite.database', value: ':memory:');
    }
}
