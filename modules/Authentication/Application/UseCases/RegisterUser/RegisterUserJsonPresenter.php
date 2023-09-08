<?php

declare(strict_types=1);

namespace Modules\Authentication\Application\UseCases\RegisterUser;

use Modules\Authentication\Domain\UseCases\RegisterUser\RegisterUserResponse;
use Modules\Authentication\Domain\UseCases\RegisterUser\RegisterUserPresenterContract;

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
