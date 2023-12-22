<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Shared\Domain\Enums\Http;
use Illuminate\Validation\ValidationException;
use Modules\Residence\Infrastructure\Models\View;

use function Modules\Shared\Infrastructure\Helpers\string_value;

final class ViewController
{
    /**
     * @throws \InvalidArgumentException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate(rules: [
            'device_name' => 'required|string',
            'device_token' => 'required|string',
            'residence_id' => 'required|string|exists:residences,id',
        ]);

        $residence = string_value(value: $request->post(key: 'residence_id'));
        $device = Arr::join(glue: '/', array: $request->only(keys: ['device_name', 'device_token']));

        if (
            View::query()
                ->where(column: 'device', operator: '=', value: $device)
                ->where(column: 'residence_id', operator: '=', value: $residence)
                ->exists()
        ) {
            throw ValidationException::withMessages(messages: [
                'residence_id' => [trans(key: 'residence::messages.view.add.error', replace: ['id' => $device])],
            ]);
        }

        try {
            View::query()->create(attributes: ['device' => $device, 'residence_id' => $residence]);
        } catch (\Throwable $th) {
            report(exception: $th);

            return response()->json(
                status: Http::INTERNAL_SERVER_ERROR->value,
                data: ['success' => false, 'message' => trans(key: 'shared::messages.errors.server')]
            );
        }

        return response()->json(
            status: Http::OK->value,
            data: [
                'success' => true,
                'message' => trans(key: 'residence::messages.view.add.success', replace: ['id' => $device]),
            ]
        );
    }
}
