<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Shared\Domain\Enums\Http;
use Modules\Residence\Infrastructure\Models\Favorite;
use Modules\Residence\Infrastructure\Models\Residence;
use Modules\Residence\Infrastructure\Http\Resources\FavoriteResidenceResource;

final class FavoriteController
{
    /**
     * @throws \RuntimeException
     */
    public function index(): JsonResponse
    {
        return response()->json(
            status: Http::OK->value,
            data: [
                'success' => true,
                'message' => trans(key: 'residence::messages.favorite.listing'),
                'residences' => FavoriteResidenceResource::collection(
                    resource: Residence::query()
                        ->whereRelation(relation: 'favorites', column: 'user_id', operator: '=', value: Auth::id())
                        ->with(relations: ['poster'])
                        ->get(columns: ['id', 'name', 'address'])
                ),
            ]
        );
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate(rules: ['residence_id' => 'required|string|exists:residences,id']);

        try {
            Favorite::query()->create(attributes: [
                'user_id' => Auth::id(),
                'residence_id' => $request->post(key: 'residence_id'),
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
            data: ['success' => true, 'message' => trans(key: 'residence::messages.favorite.add')]
        );
    }

    public function destroy(string $residence): JsonResponse
    {
        try {
            $favorite = Favorite::query()->where(column: 'residence_id', operator: '=', value: $residence)->first();

            if (\is_null(value: $favorite)) {
                return response()->json(
                    status: Http::OK->value,
                    data: [
                        'success' => false,
                        'message' => trans(key: 'residence::messages.favorite.remove.error', replace: ['id' => $residence]),
                    ]
                );
            }

            $favorite->delete();
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
                'message' => trans(key: 'residence::messages.favorite.remove.success', replace: ['id' => $residence]),
            ]
        );
    }
}
