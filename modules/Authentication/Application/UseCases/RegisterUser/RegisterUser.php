<?php

declare(strict_types=1);

namespace Modules\Authentication\Application\UseCases\RegisterUser;

use Modules\Authentication\Domain\Enums\Roles;
use Modules\Authentication\Domain\Entities\User;
use Modules\Shared\Domain\Commands\GenerateUlidContract;
use Modules\Authentication\Domain\Repositories\AuthRepository;
use Modules\Authentication\Domain\Actions\DispatchOneTimePasswordContract;
use Modules\Authentication\Domain\UseCases\RegisterUser\RegisterUserRequest;
use Modules\Authentication\Domain\UseCases\RegisterUser\RegisterUserContract;
use Modules\Authentication\Domain\UseCases\RegisterUser\RegisterUserResponse;
use Modules\Authentication\Domain\UseCases\RegisterUser\RegisterUserPresenterContract;

final readonly class RegisterUser implements RegisterUserContract
{
    public function __construct(
        private GenerateUlidContract $ulid,
        private AuthRepository $repository,
        private DispatchOneTimePasswordContract $otp,
    ) {
        //
    }

    public function execute(RegisterUserRequest $request, RegisterUserPresenterContract $presenter): void
    {
        $user = new User(
            id: $this->ulid->handle(),
            forename: $request->forename,
            surname: $request->surname,
            email: $request->email,
            password: $request->password,
        );

        if (! $this->repository->register(user: $user)) {
            $presenter->present(response: new RegisterUserResponse(
                failed: true,
                message: "Échec de la création d'un utilisateur. Veuillez réessayer plus tard.",
            ));

            return;
        }

        if (! $this->repository->bind(user: $user->id, roles: [Roles::Client, Roles::Provider])) {
            $presenter->present(response: new RegisterUserResponse(
                failed: true,
                message: "Échec de l'association du rôle à l'utilisateur. Veuillez réessayer.",
            ));

            return;
        }

        $this->otp->execute(email: $user->email);

        $presenter->present(response: new RegisterUserResponse(
            failed: false,
            message: "L'enregistrement a été effectué avec succès. Vous pouvez maintenant vous connecter.",
        ));
    }
}
