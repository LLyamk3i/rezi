<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Shared\Infrastructure\Factories\ImageUrlFactory;

final class UserResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var \Modules\Authentication\Infrastructure\Models\User
     */
    public $resource;

    /**
     * @return array<string,mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            ...$this->resource->toArray(),
            'avatar' => ImageUrlFactory::make(path: $this->resource->avatar?->getAttribute(key: 'path')),
        ];
    }
}
