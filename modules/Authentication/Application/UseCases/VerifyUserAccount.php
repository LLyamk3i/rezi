<?php

declare(strict_types=1);

namespace Modules\Authentication\Application\UseCases;

use Modules\Authentication\Domain\Repositories\AccountRepository;
use Modules\Authentication\Domain\Commands\RetrievesOneTimePasswordContract;
use Modules\Authentication\Domain\UseCases\VerifyUserAccount\VerifyUserAccountRequest;
use Modules\Authentication\Domain\UseCases\VerifyUserAccount\VerifyUserAccountContract;
use Modules\Authentication\Domain\UseCases\VerifyUserAccount\VerifyUserAccountResponse;

final class VerifyUserAccount implements VerifyUserAccountContract
{
    public function __construct(
        private readonly AccountRepository $repository,
        private readonly RetrievesOneTimePasswordContract $retriever,
    ) {
        //
    }

    public function execute(VerifyUserAccountRequest $request): VerifyUserAccountResponse
    {
        $account = $this->repository->find(id: $request->id);

        if (\is_null(value: $account)) {
            return new VerifyUserAccountResponse(
                status: 400,
                failed: true,
                message: "Compte introuvable : Veuillez vérifier vos informations d'identification.",
            );
        }

        if ($account->verified) {
            return new VerifyUserAccountResponse(
                status: 400,
                failed: true,
                message: 'Compte déjà vérifié : Vous êtes prêt à commencer !',
            );
        }

        $code = $this->retriever->handle(email: $account->email);

        if (! ($code === $request->code->value)) {
            return new VerifyUserAccountResponse(
                status: 500,
                failed: true,
                message: 'Le code fournie est incorrect.',
            );
        }

        if (! $this->repository->verify(id: $request->id)) {
            return new VerifyUserAccountResponse(
                status: 500,
                failed: true,
                message: "Une erreur s'est produite lors de la vérification du compte. Veuillez réessayer ou contacter le support.",
            );
        }

        return new VerifyUserAccountResponse(
            status: 200,
            failed: false,
            message: 'Votre compte a bien été vérifié.',
        );
    }
}
