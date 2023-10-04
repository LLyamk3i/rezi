<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Http;

use Modules\Shared\Domain\UseCases\Response;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse as HttpJsonResponse;

final class JsonResponse implements Responsable
{
    /**
     * @param array<string,int|string> $data
     */
    public function __construct(
        private readonly Response $response,
        private readonly array $data = [],
    ) {
        //
    }

    /**
     * @param \Illuminate\Http\Request $request
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
