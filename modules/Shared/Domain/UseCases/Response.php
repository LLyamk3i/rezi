<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\UseCases;

final class Response
{
    public function __construct(
        public int $status,
        public bool $failed,
        public string $message,
    ) {
        //
    }
}
