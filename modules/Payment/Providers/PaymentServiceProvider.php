<?php

declare(strict_types=1);

namespace Modules\Payment\Providers;

use Modules\Payment\Domain;
use Modules\Payment\Application;
use Modules\Payment\Infrastructure;
use Illuminate\Support\ServiceProvider;
use Modules\Payment\Application\Commands\GeneratePayment;
use Modules\Shared\Infrastructure\Generators\UlidGenerator;
use Modules\Payment\Domain\Commands\GeneratePaymentContract;

final class PaymentServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string,class-string>
     */
    public array $bindings = [
        Domain\UseCases\UpdatePayment\UpdatePaymentContract::class => Application\UseCases\UpdatePayment::class,
        Domain\Commands\VerifyPaymentOwnershipContract::class => Application\Commands\VerifyPaymentOwnership::class,
        Domain\Repositories\PaymentRepository::class => Infrastructure\Eloquent\Repositories\EloquentPaymentRepository::class,
        Domain\UseCases\GeneratePaymentKey\GeneratePaymentKeyContract::class => Application\UseCases\GeneratePaymentKey::class,
    ];

    public function boot(): void
    {
        $this->loadMigrationsFrom(paths: __DIR__ . '/../Infrastructure/Database/Migrations');
        $this->loadTranslationsFrom(path: __DIR__ . '/../lang', namespace: 'payment');
    }

    public function register(): void
    {
        $this->app->register(provider: RouteServiceProvider::class);
        $this->app->bind(abstract: GeneratePaymentContract::class, concrete: static fn (): GeneratePayment => new GeneratePayment(ulid: new UlidGenerator()));
    }
}
