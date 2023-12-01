<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Shared\Domain\Enums\Http;
use Modules\Residence\Infrastructure\Models\Feature;
use Modules\Residence\Infrastructure\Http\Resources\FeatureResource;

final class FeatureController
{
    public function index(): JsonResponse
    {
        return response()->json(
            status: Http::OK->value,
            data: [
                'success' => true,
                'message' => trans(key: 'residence::messages.feature.listing'),
                'features' => FeatureResource::collection(
                    resource: Feature::query()->with(relations: ['icon'])->get(columns: ['id', 'name'])
                ),
            ]
        );
    }
}
