<?php

declare(strict_types=1);

namespace Modules\Admin\Providers;

use Modules\Residence\Infrastructure\Models\Residence;
use Modules\Admin\Infrastructure\Policies\ResidencePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

final class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string,class-string>
     */
    protected $policies = [
        Residence::class => ResidencePolicy::class,
    ];
}
