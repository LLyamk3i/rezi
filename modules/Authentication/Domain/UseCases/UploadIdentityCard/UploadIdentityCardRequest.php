<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\UseCases\UploadIdentityCard;

use Modules\Authentication\Domain\Entities\User;
use Modules\Authentication\Domain\Services\UploadIdentityCardServiceContract;

final class UploadIdentityCardRequest
{
    public function __construct(
        public readonly string $map,
        public readonly User $account,
        public readonly UploadIdentityCardServiceContract $upload,
    ) {
        //
    }
}
