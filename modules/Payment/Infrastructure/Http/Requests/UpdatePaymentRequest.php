<?php

declare(strict_types=1);

namespace Modules\Payment\Infrastructure\Http\Requests;

use Illuminate\Validation\Rules\Enum;
use Modules\Payment\Domain\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Authentication\Domain\Services\AuthenticatedUserService;
use Modules\Payment\Domain\UseCases\UpdatePayment\UpdatePaymentRequest as Request;

use function Modules\Shared\Infrastructure\Helpers\make_ulid_value;

final class UpdatePaymentRequest extends FormRequest
{
    /**
     * @return array{status:array{'required',Enum}}
     */
    public function rules(): array
    {
        return [
            'status' => ['required', new Enum(Status::class)],
        ];
    }

    public function approved(): Request
    {
        /** @var \Modules\Authentication\Domain\Services\AuthenticatedUserService $service */
        $service = resolve(AuthenticatedUserService::class);

        $status = $this->enum(key: 'status', enumClass: Status::class);

        if (! ($status instanceof Status)) {
            throw new \Exception(message: 'Error Processing Request', code: 1);
        }

        return new Request(
            status: $status,
            client: $service->run(),
            payment: make_ulid_value(value: $this->route(param: 'payment')),
        );
    }
}
