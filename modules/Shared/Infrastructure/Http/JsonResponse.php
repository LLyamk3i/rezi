<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Http;

use Modules\Shared\Domain\UseCases\Response;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse as HttpJsonResponse;

final class JsonResponse implements Responsable
{
    public function __construct(
        private readonly Response $response,
    ) {
        //
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request): HttpJsonResponse
    {
        return new HttpJsonResponse(
            status: $this->response->status,
            data: [
                'success' => ! $this->response->failed,
                'message' => $this->response->message,
            ]
        );
    }
}
