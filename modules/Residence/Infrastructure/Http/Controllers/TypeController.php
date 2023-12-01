<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Shared\Domain\Enums\Http;
use Modules\Residence\Infrastructure\Models\Type;

final class TypeController
{
    public function index(): JsonResponse
    {
        return response()->json(
            status: Http::OK->value,
            data: [
                'success' => true,
                'message' => trans(key: 'residence::messages.type.listing'),
                'types' => Type::all(columns: ['id', 'name']),
            ]
        );
    }
}
