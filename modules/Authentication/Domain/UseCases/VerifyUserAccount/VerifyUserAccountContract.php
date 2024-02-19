<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\UseCases\VerifyUserAccount;

use Modules\Shared\Domain\UseCases\Response;

interface VerifyUserAccountContract
{
    public function execute(VerifyUserAccountRequest $request): Response;
}
