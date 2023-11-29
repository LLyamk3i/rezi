<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class ResidencesResource extends JsonResource
{
    /**
     * @var \Modules\Residence\Domain\Entities\Residence
     */
    public $resource;

    /**
     * @return array{id:string,name:string,address:string,description:string,distance:string,location:\Modules\Residence\Domain\ValueObjects\Location,rent:array{value:float,format:string}}
     */
    public function toArray(Request $request): array
    {
        return $this->resource->__serialize();
    }
}
