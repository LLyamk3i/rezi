<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\UseCases\VerifyUserAccount;

use Modules\Authentication\Domain\ValueObjects\Otp;
use Modules\Authentication\Domain\ValueObjects\Email;

final readonly class VerifyUserAccountRequest
{
    public function __construct(
        public Email $email,
        public Otp $code,
    ) {
        //
    }
}
