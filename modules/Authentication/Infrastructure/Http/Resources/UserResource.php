<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'avatar' => [
                'link' => $this->resource->avatar?->getAttribute(key: 'path'),
                'usage' => route(name: 'image.show', parameters: [
                    'h' => 500,
                    'w' => 500,
                    'path' => $this->resource->avatar?->getAttribute(key: 'path'),
                ]),
            ],
        ];
    }
}
