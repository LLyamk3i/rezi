<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Http;

use Modules\Shared\Domain\UseCases\Response;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse as HttpJsonResponse;

final readonly class JsonResponse implements Responsable
{
    /**
     * @param array<string,int|string> $data
     */
    public function __construct(
        private Response $response,
        private array $data = [],
    ) {
        //
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @throws \InvalidArgumentException
     */
    public function toResponse($request): HttpJsonResponse
    {
        return new HttpJsonResponse(
            status: $this->response->status,
            data: [
                'success' => ! $this->response->failed,
                'message' => $this->response->message,
                ...$this->data,
            ]
        );
    }
}
