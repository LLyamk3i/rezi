<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\UseCases\UploadIdentityCard;

use Modules\Shared\Domain\UseCases\Response;

interface UploadIdentityCardContract
{
    public function execute(UploadIdentityCardRequest $request): Response;
}
