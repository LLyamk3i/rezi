<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\UseCases\VerifyUserAccount;

final class VerifyUserAccountResponse
{
    public function __construct(
        public readonly int $status,
        public readonly bool $failed,
        public readonly string $message,
    ) {
        //
    }
}
