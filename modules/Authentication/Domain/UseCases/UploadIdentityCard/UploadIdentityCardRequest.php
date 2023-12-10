<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\UseCases\UploadIdentityCard;

use Modules\Authentication\Domain\Entities\User;
use Modules\Authentication\Domain\Services\UploadIdentityCardServiceContract;

final readonly class UploadIdentityCardRequest
{
    public function __construct(
        public string $fileable,
        public User $account,
        public UploadIdentityCardServiceContract $upload,
    ) {
        //
    }
}
