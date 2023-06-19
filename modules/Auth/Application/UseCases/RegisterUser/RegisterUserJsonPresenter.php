<?php

declare(strict_types=1);

namespace Modules\Auth\Application\UseCases\RegisterUser;

use Modules\Auth\Domain\UseCases\RegisterUser\RegisterUserResponse;
use Modules\Auth\Domain\UseCases\RegisterUser\RegisterUserPresenterContract;

final class RegisterUserJsonPresenter implements RegisterUserPresenterContract
{
    private RegisterUserJsonViewModel $viewModel;

    public function present(RegisterUserResponse $response): void
    {
        $this->viewModel = new RegisterUserJsonViewModel(
            success: ! $response->failed,
            message: $response->message,
        );
    }

    public function viewModel(): RegisterUserJsonViewModel
    {
        return $this->viewModel;
    }
}
