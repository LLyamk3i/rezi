<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\Contracts;

use Modules\Shared\Domain\ValueObjects\Ulid;

interface VerifyUserAccessManagerContract
{
    public function owner(Ulid $user): bool;

    public function admin(Ulid $user): bool;

    public function provider(Ulid $user): bool;
}
