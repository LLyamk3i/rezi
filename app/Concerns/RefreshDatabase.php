<?php

declare(strict_types=1);

namespace App\Concerns;

use Illuminate\Foundation\Testing\RefreshDatabaseState;

trait RefreshDatabase
{
    public function refreshDatabase(): void
    {
        if (! RefreshDatabaseState::$migrated) {
            $this->artisan('migrate:fresh', $this->migrateFreshUsing());

            $this->app[Kernel::class]->setArtisan(null);

            RefreshDatabaseState::$migrated = true;
        }

        $this->beginDatabaseTransaction();
    }
}
