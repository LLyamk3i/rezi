<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use function Modules\Shared\Infrastructure\Helpers\array_filter_filled;

final class OwnerResource extends JsonResource
{
    /**
     * @var \Modules\Residence\Domain\Entities\Owner
     */
    public $resource;

    /**
     * @return array<string,array<string,float|string>|\Modules\Residence\Domain\ValueObjects\Location|string>
     */
    public function toArray(Request $request): array
    {
        $residence = $this->resource->__serialize();

        return array_filter_filled(array: [
            ...$residence,
            'avatar' => $this->avatar(),
        ]);
    }

    private function avatar(): string | null
    {
        if ($this->resource->avatar === null) {
            return null;
        }

        return route(name: 'image.show', parameters: ['path' => $this->resource->avatar, 'h' => 50, 'w' => 50]);
    }
}
