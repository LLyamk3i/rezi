<?php

declare(strict_types=1);

namespace Modules\Authentication\Application\UseCases;

use Modules\Shared\Domain\Enums\Http;
use Modules\Shared\Domain\UseCases\Response;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Modules\Shared\Domain\Repositories\MediaRepository;
use Modules\Shared\Domain\Contracts\MediaExistsQueryContract;
use Modules\Authentication\Domain\Contracts\MediaIdentityExistsQueryContract as Query;
use Modules\Authentication\Domain\UseCases\UploadIdentityCard\UploadIdentityCardRequest;
use Modules\Authentication\Domain\UseCases\UploadIdentityCard\UploadIdentityCardContract;

final readonly class UploadIdentityCard implements UploadIdentityCardContract
{
    public function __construct(
        private Application $app,
        private Translator $translator,
        private MediaRepository $repository,
        private ExceptionHandler $exception,
    ) {
        //
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function execute(UploadIdentityCardRequest $request): Response
    {
        try {
            $query = $this->app->make(abstract: Query::class, parameters: ['user' => $request->account->id]);

            if (! ($query instanceof MediaExistsQueryContract)) {
                throw new \RuntimeException(message: 'Error Processing Request MediaExistsQueryContract', code: 1);
            }
            if ($this->repository->exists(query: $query)) {
                return new Response(
                    failed: true,
                    status: Http::NOT_IMPLEMENTED,
                    message: $this->translator->choice(key: 'authentication::messages.uploads.identity-card.errors.exists', number: 0),
                );
            }

            $identity = $request->upload->run();
            $inserted = $this->repository->insert(media: $identity->toArray(), user: $request->account->id, fileable: $request->fileable);

            if (! $inserted) {
                return new Response(
                    failed: true,
                    status: Http::NOT_IMPLEMENTED,
                    message: $this->translator->choice(key: 'authentication::messages.uploads.identity-card.errors.save', number: 0),
                );
            }
        } catch (\Throwable $throwable) {
            $this->exception->report(e: $throwable);

            return new Response(
                failed: true,
                status: Http::INTERNAL_SERVER_ERROR,
                message: $this->translator->choice(key: 'shared::messages.errors.server', number: 0),
            );
        }

        return new Response(
            failed: false,
            status: Http::OK,
            message: $this->translator->choice(key: 'authentication::messages.uploads.identity-card.success', number: 0),
        );
    }
}
