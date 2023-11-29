<?php

declare(strict_types=1);

namespace Modules\Payment\Infrastructure\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Shared\Domain\Enums\Http;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Symfony\Component\HttpFoundation\Response;
use Modules\Payment\Domain\Commands\VerifyPaymentOwnershipContract;

use function Modules\Shared\Infrastructure\Helpers\string_value;

final class RejectUnownedPaymentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws \Modules\Shared\Domain\Exceptions\InvalidValueObjectException
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var VerifyPaymentOwnershipContract $command */
        $command = resolve(name: VerifyPaymentOwnershipContract::class);
        $owned = $command->handle(
            payment: new Ulid(value: string_value(value: $request->route(param: 'payment'))),
            client: new Ulid(value: string_value(value: Auth::id())),
        );

        if (! $owned) {
            abort(code: Http::FORBIDDEN->value, message: trans(key: 'payment::validation.unauthorized.client'));
        }

        return $next($request);
    }
}
