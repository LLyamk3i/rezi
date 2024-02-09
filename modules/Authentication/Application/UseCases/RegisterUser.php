<?php

declare(strict_types=1);

namespace Modules\Authentication\Application\UseCases;

use Modules\Shared\Domain\Enums\Http;
use Modules\Shared\Domain\UseCases\Response;
use Modules\Authentication\Domain\Enums\Roles;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\Translation\Translator;
use Modules\Shared\Domain\Supports\TransactionContract;
use Modules\Authentication\Domain\Repositories\AuthRepository;
use Modules\Authentication\Domain\Actions\DispatchOneTimePasswordContract;
use Modules\Authentication\Domain\UseCases\RegisterUser\RegisterUserRequest;
use Modules\Authentication\Domain\UseCases\RegisterUser\RegisterUserContract;

use function Modules\Shared\Infrastructure\Helpers\string_value;

final readonly class RegisterUser implements RegisterUserContract
{
    public function __construct(
        private Translator $translator,
        private AuthRepository $repository,
        private ExceptionHandler $exception,
        private DispatchOneTimePasswordContract $otp,
        private TransactionContract $transaction,
    ) {
        //
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function execute(RegisterUserRequest $request): Response
    {
        $this->transaction->start();

        try {
            if (! $this->repository->register(user: $request->user)) {
                return new Response(
                    status: Http::NOT_IMPLEMENTED,
                    failed: true,
                    message: trans(key: 'authentication::messages.register.errors.creation'),
                );
            }
        } catch (\Throwable $throwable) {
            $this->exception->report(e: $throwable);
            $this->transaction->cancel();

            return new Response(
                failed: true,
                status: Http::INTERNAL_SERVER_ERROR,
                message: string_value(value: $this->translator->get(key: 'shared::messages.errors.server')),
            );
        }

        try {
            if (! $this->repository->bind(user: $request->user->id, roles: [Roles::Client, Roles::Provider])) {
                return new Response(
                    status: Http::NOT_IMPLEMENTED,
                    failed: true,
                    message: trans(key: 'authentication::messages.register.errors.binding'),
                );
            }
        } catch (\Throwable $throwable) {
            $this->exception->report(e: $throwable);
            $this->transaction->cancel();

            return new Response(
                failed: true,
                status: Http::INTERNAL_SERVER_ERROR,
                message: string_value(value: $this->translator->get(key: 'shared::messages.errors.server')),
            );
        }

        try {
            $this->otp->execute(user: $request->user);
        } catch (\Throwable $throwable) {
            $this->exception->report(e: $throwable);

            return new Response(
                failed: true,
                status: Http::INTERNAL_SERVER_ERROR,
                message: string_value(value: $this->translator->get(key: 'authentication::messages.register.errors.otp')),
            );
        }

        $this->transaction->commit();

        return new Response(
            status: Http::CREATED,
            failed: false,
            message: trans(key: 'authentication::messages.register.success'),
        );
    }
}
