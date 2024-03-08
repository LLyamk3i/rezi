<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;
use Modules\Shared\Domain\Supports\StoreContract;
use Modules\Residence\Infrastructure\Resources\ResidenceResource;
use Modules\Residence\Domain\UseCases\ResidencesResponse as UseCasesResidencesResponse;

final readonly class ResidenceResponse implements Responsable
{
    public function __construct(
        public UseCasesResidencesResponse $response,
    ) {
        //
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @throws \InvalidArgumentException
     */
    public function toResponse($request): JsonResponse
    {
        app(abstract: StoreContract::class)->put(key: 'inventory', value: $this->response->inventory);

        return new JsonResponse(
            status: $this->response->status->value,
            data: [
                'success' => ! $this->response->failed,
                'message' => $this->response->message,
                ...$this->residences(),
                ...$this->residence(),
            ],
        );
    }

    /**
     * @return array<string,ResidenceResource|null>
     */
    public function residence(): array
    {
        if (! $this->response->residence instanceof \Modules\Residence\Domain\Entities\Residence) {
            return ['residence' => null];
        }

        return ['residence' => new ResidenceResource(resource: $this->response->residence)];
    }

    /**
     * @return array<string,mixed>
     */
    private function residences(): array
    {
        if ($this->response->residences === null) {
            return ['residences' => null];
        }

        if (\is_array(value: $this->response->residences)) {
            return [
                'residences' => [
                    'total' => \count(value: $this->response->residences),
                    'items' => ResidenceResource::collection(resource: $this->response->residences),
                ],
            ];
        }

        return [
            'residences' => [
                'total' => $this->response->residences->total,
                'items' => ResidenceResource::collection(resource: $this->response->residences->items),
                'page' => [
                    'per' => $this->response->residences->page->per,
                    'last' => $this->response->residences->page->last,
                    'current' => $this->response->residences->page->current,
                ],
            ],
        ];
    }
}
