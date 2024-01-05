<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\UseCases\RegisterUser;

use Modules\Shared\Domain\UseCases\Response;

interface RegisterUserContract
{
    public function execute(RegisterUserRequest $request): Response;
}
