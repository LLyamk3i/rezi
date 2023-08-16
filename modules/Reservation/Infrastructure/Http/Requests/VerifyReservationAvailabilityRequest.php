<?php

declare(strict_types=1);

namespace Modules\Reservation\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Shared\Domain\ValueObjects\Duration;

use function Modules\Shared\Infrastructure\Helpers\string_value;

final class VerifyReservationAvailabilityRequest extends FormRequest
{
    /**
     * @return array{checkin_date:string,checkout_date:string,residence_id:string}
     */
    public function rules(): array
    {
        return [
            'checkin_date' => 'required|date',
            'checkout_date' => 'required|date',
            'residence_id' => 'required|string|exists:residences,id',
        ];
    }

    /**
     * @return array{residence:Ulid,stay:Duration}
     */
    public function approved(): array
    {
        return [
            'residence' => new Ulid(value: string_value(value: $this->input(key: 'residence_id'))),
            'stay' => new Duration(
                start: new \DateTime(datetime: string_value(value: $this->input(key: 'checkin_date'))),
                end: new \DateTime(datetime: string_value(value: $this->input(key: 'checkout_date'))),
            ),
        ];
    }
}
