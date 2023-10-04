<?php

declare(strict_types=1);

namespace Modules\Payment\Infrastructure\Rules;

use Closure;
use Illuminate\Support\Facades\Auth;
use Modules\Shared\Domain\Enums\Http;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Illuminate\Contracts\Validation\ValidationRule;
use Modules\Reservation\Domain\Commands\VerifyReservationOwnershipContracts;

use Modules\Reservation\Infrastructure\Eloquent\Repositories\Methods\ReservationOwnershipVerificationQuery;

use function Modules\Shared\Infrastructure\Helpers\string_value;

final class ReservationBelongsToAuthenticatedClient implements ValidationRule
{
    /**
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        /** @var VerifyReservationOwnershipContracts $command */
        $command = resolve(name: VerifyReservationOwnershipContracts::class, parameters: [
            'query' => new ReservationOwnershipVerificationQuery(
                reservation: new Ulid(value: string_value(value: $value)),
                owner: new Ulid(value: string_value(value: Auth::id())),
            ),
        ]);
        if (! $command->handle()) {
            abort(code: Http::FORBIDDEN->value, message: trans(key: 'payment::validation.unauthorized.client'));
        }
    }
}
