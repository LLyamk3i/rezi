<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;
use Modules\Residence\Infrastructure\Resources\ResidencesResource;
use Modules\Residence\Domain\UseCases\ResidencesResponse as UseCasesResidencesResponse;

final class ResidenceResponse implements Responsable
{
    public function __construct(
        public readonly UseCasesResidencesResponse $response,
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
        return new JsonResponse(
            status: $this->response->status->value,
            data: [
                'success' => ! $this->response->failed,
                'message' => $this->response->message,
                'residences' => $this->residences(),
            ],
        );
    }

    /**
     * @return null|array{total:int}
     */
    private function residences(): array | null
    {
        if ($this->response->residences === null) {
            return null;
        }

        return [
            'total' => $this->response->residences->total,
            'items' => ResidencesResource::collection(resource: $this->response->residences->items),
            'page' => [
                'per' => $this->response->residences->page->per,
                'last' => $this->response->residences->page->last,
                'current' => $this->response->residences->page->current,
            ],
        ];
    }
}
