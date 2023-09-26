<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\Services;

use Modules\Authentication\Domain\ValueObjects\Cards\Identity;

interface UploadIdentityCardServiceContract
{
    public function run(): Identity;
}
