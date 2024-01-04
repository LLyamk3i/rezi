<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class OwnerResource extends JsonResource
{
    /**
     * @var \Modules\Residence\Domain\Entities\Owner
     */
    public $resource;

    /**
     * @return array{id: string, name: string, avatar: string|null}
     */
    public function toArray(Request $request): array
    {
        return [...$this->resource->__serialize(), 'avatar' => $this->avatar()];
    }

    private function avatar(): string | null
    {
        if ($this->resource->avatar === null) {
            return null;
        }

        return route(name: 'image.show', parameters: ['path' => $this->resource->avatar, 'h' => 50, 'w' => 50]);
    }
}
