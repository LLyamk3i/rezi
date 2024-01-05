<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Modules\Shared\Domain\Enums\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Modules\Residence\Infrastructure\Models\Rating;

use function Modules\Shared\Infrastructure\Helpers\string_value;

final class RatingController
{
    /**
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        Validator::validate(data: $request->all(), rules: [
            'comment' => 'string',
            'rating' => 'required|integer',
            'residence_id' => 'required|string|exists:residences,id',
        ]);

        $residence = string_value(value: $request->post(key: 'residence_id'));

        if (
            DB::table(table: 'ratings')
                ->where(column: 'user_id', operator: '=', value: Auth::id())
                ->where(column: 'residence_id', operator: '=', value: $residence)
                ->exists()
        ) {
            throw ValidationException::withMessages(messages: [
                'residence_id' => [
                    trans(key: 'residence::messages.rating.add.error', replace: ['id' => string_value(value: Auth::id())]),
                ],
            ]);
        }

        try {
            Rating::query()->create(attributes: [
                'user_id' => Auth::id(),
                'residence_id' => $residence,
                'comment' => $request->post(key: 'comment'),
                'value' => $request->post(key: 'rating'),
            ]);
        } catch (\Throwable $throwable) {
            report(exception: $throwable);

            return response()->json(
                status: Http::INTERNAL_SERVER_ERROR->value,
                data: ['success' => false, 'message' => trans(key: 'shared::messages.errors.server')]
            );
        }

        return response()->json(
            status: Http::OK->value,
            data: [
                'success' => true,
                'message' => trans(key: 'residence::messages.rating.add.success', replace: ['id' => string_value(value: Auth::id())]),
            ]
        );
    }
}
