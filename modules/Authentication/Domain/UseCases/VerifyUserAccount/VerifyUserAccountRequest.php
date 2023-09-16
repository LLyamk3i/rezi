<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\UseCases\VerifyUserAccount;

use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Authentication\Domain\ValueObjects\Otp;

final class VerifyUserAccountRequest
{
    public function __construct(
        public readonly Ulid $id,
        public readonly Otp $code,
    ) {
        //
    }
}
