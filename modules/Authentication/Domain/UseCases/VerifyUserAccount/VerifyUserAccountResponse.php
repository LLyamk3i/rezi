<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\UseCases\VerifyUserAccount;

final readonly class VerifyUserAccountResponse
{
    public function __construct(
        public int $status,
        public bool $failed,
        public string $message,
    ) {
        //
    }
}
