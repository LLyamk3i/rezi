<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\UseCases\RegisterUser;

interface RegisterUserPresenterContract
{
    public function present(RegisterUserResponse $response): void;
}
