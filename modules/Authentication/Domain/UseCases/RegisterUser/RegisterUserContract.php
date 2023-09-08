<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\UseCases\RegisterUser;

interface RegisterUserContract
{
    public function execute(RegisterUserRequest $request, RegisterUserPresenterContract $presenter): void;
}
