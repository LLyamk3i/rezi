<?php

declare(strict_types=1);

namespace Modules\Auth\Domain\UseCases\RegisterUser;

interface RegisterUserContract
{
    public function execute(RegisterUserRequest $request, RegisterUserPresenterContract $presenter): void;
}
