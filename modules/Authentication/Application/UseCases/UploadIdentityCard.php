<?php

declare(strict_types=1);

namespace Modules\Authentication\Application\UseCases;

use Modules\Shared\Domain\Enums\Http;
use Modules\Shared\Domain\UseCases\Response;
use Illuminate\Contracts\Translation\Translator;
use Modules\Shared\Domain\Repositories\MediaRepository;
use Modules\Authentication\Domain\UseCases\UploadIdentityCard\UploadIdentityCardRequest;
use Modules\Authentication\Domain\UseCases\UploadIdentityCard\UploadIdentityCardContract;

use function Modules\Shared\Infrastructure\Helpers\string_value;

final readonly class UploadIdentityCard implements UploadIdentityCardContract
{
    public function __construct(
        private Translator $translator,
        private MediaRepository $repository,
    ) {
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function execute(UploadIdentityCardRequest $request): Response
    {
        try {
            $identity = $request->upload->run();
        } catch (\Throwable $throwable) {
            report($throwable);

            return new Response(
                failed: true,
                status: Http::INTERNAL_SERVER_ERROR,
                message: string_value(value: $this->translator->get(key: 'authentication::messages.uploads.identity-card.errors.upload')),
            );
        }

        try {
            $this->repository->insert(
                media: $identity->toArray(),
                user: $request->account->id,
                fileable: $request->fileable,
            );
        } catch (\Throwable $throwable) {
            report($throwable);

            return new Response(
                failed: true,
                status: Http::INTERNAL_SERVER_ERROR,
                message: string_value(value: $this->translator->get(key: 'authentication::messages.uploads.identity-card.errors.save')),
            );
        }

        return new Response(
            failed: false,
            status: Http::OK,
            message: string_value(value: $this->translator->get(key: 'authentication::messages.uploads.identity-card.success')),
        );
    }
}
