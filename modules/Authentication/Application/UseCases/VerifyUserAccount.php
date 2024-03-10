<?php

declare(strict_types=1);

namespace Modules\Authentication\Application\UseCases;

use Modules\Shared\Domain\Enums\Http;
use Modules\Shared\Domain\UseCases\Response;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Contracts\Config\Repository as ConfigContract;
use Modules\Authentication\Domain\Repositories\AccountRepository;
use Modules\Authentication\Domain\Commands\RetrievesOneTimePasswordContract;
use Modules\Authentication\Domain\UseCases\VerifyUserAccount\VerifyUserAccountRequest;
use Modules\Authentication\Domain\UseCases\VerifyUserAccount\VerifyUserAccountContract;

use function Modules\Shared\Infrastructure\Helpers\string_value;
use function Modules\Shared\Infrastructure\Helpers\boolean_value;

final readonly class VerifyUserAccount implements VerifyUserAccountContract
{
    public function __construct(
        private ConfigContract $config,
        private Translator $translator,
        private ExceptionHandler $exception,
        private AccountRepository $repository,
        private RetrievesOneTimePasswordContract $retriever,
    ) {
        //
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function execute(VerifyUserAccountRequest $request): Response
    {
        try {
            $account = $this->repository->find(email: $request->email);

            if (\is_null(value: $account)) {
                return new Response(
                    failed: true,
                    status: Http::BAD_REQUEST,
                    message: $this->translator->choice(key: 'authentication::messages.verification.errors.account.missing', number: 0),
                );
            }

            if ($account->verified) {
                return new Response(
                    failed: true,
                    status: Http::BAD_REQUEST,
                    message: string_value(value: $this->translator->get(key: 'authentication::messages.verification.errors.account.verified')),
                );
            }

            if (boolean_value(value: $this->config->get(key: 'app.setting.otp.enable'))) {
                $code = $this->retriever->handle(email: $account->email);

                if ($code !== $request->code->value) {
                    return new Response(
                        failed: true,
                        status: Http::BAD_REQUEST,
                        message: string_value(value: $this->translator->get(key: 'authentication::messages.verification.errors.incorrect')),
                    );
                }
            }

            if (! $this->repository->verify(id: $account->id)) {
                return new Response(
                    failed: true,
                    status: Http::INTERNAL_SERVER_ERROR,
                    message: string_value(value: $this->translator->get(key: 'authentication::messages.verification.errors.account.cannot')),
                );
            }
        } catch (\Throwable $throwable) {
            $this->exception->report(e: $throwable);

            return new Response(
                failed: true,
                status: Http::INTERNAL_SERVER_ERROR,
                message: string_value(value: $this->translator->get(key: 'shared::messages.errors.server')),
            );
        }

        return new Response(
            failed: false,
            status: Http::OK,
            message: string_value(value: $this->translator->get(key: 'authentication::messages.verification.success')),
        );
    }
}
