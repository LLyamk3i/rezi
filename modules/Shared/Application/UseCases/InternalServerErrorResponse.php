<?php

declare(strict_types=1);

namespace Modules\Shared\Application\UseCases;

use Modules\Shared\Domain\Enums\Http;
use Modules\Shared\Domain\UseCases\Response;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\Translation\Translator;

use function Modules\Shared\Infrastructure\Helpers\string_value;

final class InternalServerErrorResponse
{
    public function __construct(
        private ExceptionHandler $exception,
        private Translator $translator,
    ) {
        //
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function handle(\Throwable $throwable): Response
    {
        $this->exception->report(e: $throwable);

        return new Response(
            failed: true,
            status: Http::INTERNAL_SERVER_ERROR,
            message: string_value(value: $this->translator->get(key: 'shared::messages.errors.server')),
        );
    }
}
