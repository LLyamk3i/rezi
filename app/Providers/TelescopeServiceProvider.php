<?php

declare(strict_types=1);

namespace App\Providers;

use Laravel\Telescope\Telescope;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\TelescopeApplicationServiceProvider;

final class TelescopeServiceProvider extends TelescopeApplicationServiceProvider
{
    public function register(): void
    {
        if ($this->app->environment() !== 'local') {
            return;
        }

        Telescope::night();

        $this->hideSensitiveRequestDetails();

        Telescope::filter(callback: function (IncomingEntry $entry): bool {
            if ($this->app->environment() === 'local') {
                return true;
            }

            if ($entry->isReportableException()) {
                return true;
            }

            if ($entry->isFailedRequest()) {
                return true;
            }

            if ($entry->isFailedJob()) {
                return true;
            }

            if ($entry->isScheduledTask()) {
                return true;
            }

            return $entry->hasMonitoredTag();
        });
    }

    /**
     * Prevent sensitive request details from being logged by Telescope.
     */
    private function hideSensitiveRequestDetails(): void
    {
        if ($this->app->environment() === 'local') {
            return;
        }

        Telescope::hideRequestParameters(attributes: ['_token']);
        Telescope::hideRequestHeaders(headers: ['cookie', 'x-csrf-token', 'x-xsrf-token']);
    }
}
