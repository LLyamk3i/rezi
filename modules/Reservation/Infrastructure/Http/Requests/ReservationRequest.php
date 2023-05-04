<?php

declare(strict_types=1);

namespace Modules\Reservation\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Reservation\Domain\UseCases\CreateReservationRequest as Request;

class ReservationRequest extends FormRequest
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

    public function approved(): Request
    {
        return new Request(
            checkin: new \DateTime(datetime: \strval(value: $this->input(key: 'checkin_date'))),
            checkout: new \DateTime(datetime: \strval(value: $this->input(key: 'checkout_date'))),
            user: new Ulid(value: \strval(value: $this->user()?->id)),
            residence: new Ulid(value: \strval(value: $this->input(key: 'residence_id'))),
        );
    }
}
