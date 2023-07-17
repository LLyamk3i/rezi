<?php

declare(strict_types=1);

namespace Modules\Auth\Application\UseCases\RegisterUser;

use Modules\Auth\Domain\Enums\Roles;
use Modules\Auth\Domain\Entities\User;
use Modules\Auth\Domain\Repositories\AuthRepository;
use Modules\Auth\Domain\UseCases\RegisterUser\RegisterUserRequest;
use Modules\Auth\Domain\UseCases\RegisterUser\RegisterUserContract;
use Modules\Auth\Domain\UseCases\RegisterUser\RegisterUserResponse;
use Modules\Auth\Domain\UseCases\RegisterUser\RegisterUserPresenterContract;

final class RegisterUser implements RegisterUserContract
{
    public function __construct(
        private readonly AuthRepository $repository,
    ) {
        //
    }

    public function execute(RegisterUserRequest $request, RegisterUserPresenterContract $presenter): void
    {
        if (! $this->repository->register(user: new User(...(array) $request))) {
            $presenter->present(response: new RegisterUserResponse(
                failed: true,
                message: "Échec de la création d'un utilisateur. Veuillez réessayer plus tard.",
            ));

            return;
        }

        if (! $this->repository->bind(user: $request->id, roles: [Roles::CLIENT, Roles::PROVIDER])) {
            $presenter->present(response: new RegisterUserResponse(
                failed: true,
                message: "Échec de l'association du rôle à l'utilisateur. Veuillez réessayer.",
            ));
        }

        $presenter->present(response: new RegisterUserResponse(
            failed: false,
            message: "L'enregistrement a été effectué avec succès. Vous pouvez maintenant vous connecter.",
        ));
    }
}
