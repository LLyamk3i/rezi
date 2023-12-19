<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\UseCases;

use Modules\Shared\Domain\Enums\Http;

final class Response
{
    /**
     * @param array<string,mixed> $data
     */
    public function __construct(
        public Http $status,
        public bool $failed,
        public string $message,
        public array $data = [],
    ) {
        //
    }
}
