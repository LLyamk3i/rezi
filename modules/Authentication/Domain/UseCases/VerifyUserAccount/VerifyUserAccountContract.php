<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\UseCases\VerifyUserAccount;

interface VerifyUserAccountContract
{
    public function execute(VerifyUserAccountRequest $request): VerifyUserAccountResponse;
}
