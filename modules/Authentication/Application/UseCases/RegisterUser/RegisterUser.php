<?php

declare(strict_types=1);

namespace Modules\Authentication\Application\UseCases\RegisterUser;

use Modules\Authentication\Domain\Enums\Roles;
use Modules\Authentication\Domain\Entities\User;
use Modules\Authentication\Domain\Repositories\AuthRepository;
use Modules\Authentication\Domain\UseCases\RegisterUser\RegisterUserRequest;
use Modules\Authentication\Domain\UseCases\RegisterUser\RegisterUserContract;
use Modules\Authentication\Domain\UseCases\RegisterUser\RegisterUserResponse;
use Modules\Authentication\Domain\UseCases\RegisterUser\RegisterUserPresenterContract;

final readonly class RegisterUser implements RegisterUserContract
{
    public function __construct(
        private AuthRepository $repository,
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

        if (! $this->repository->bind(user: $request->id, roles: [Roles::Client, Roles::Provider])) {
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
