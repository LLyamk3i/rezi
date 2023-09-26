<?php

declare(strict_types=1);

namespace Modules\Authentication\Application\UseCases;

use Modules\Shared\Domain\UseCases\Response;
use Illuminate\Contracts\Translation\Translator;
use Modules\Shared\Domain\Repositories\MediaRepository;
use Modules\Authentication\Domain\UseCases\UploadIdentityCard\UploadIdentityCardRequest;
use Modules\Authentication\Domain\UseCases\UploadIdentityCard\UploadIdentityCardContract;

use function Modules\Shared\Infrastructure\Helpers\string_value;

final class UploadIdentityCard implements UploadIdentityCardContract
{
    public function __construct(
        private readonly Translator $translator,
        private readonly MediaRepository $repository,
    ) {
    }

    public function execute(UploadIdentityCardRequest $request): Response
    {
        try {
            $identity = $request->upload->run();
        } catch (\Throwable $th) {
            report($th);

            return new Response(
                status: 500,
                failed: true,
                message: string_value(value: $this->translator->get(key: 'authentication::messages.uploads.identity-card.errors.upload')),
            );
        }

        try {
            $this->repository->insert(
                media: $identity->toArray(),
                user: $request->account->id,
                context: $request->map,
            );
        } catch (\Throwable $th) {
            report($th);

            return new Response(
                status: 500,
                failed: true,
                message: string_value(value: $this->translator->get(key: 'authentication::messages.uploads.identity-card.errors.save')),
            );
        }

        return new Response(
            status: 200,
            failed: false,
            message: string_value(value: $this->translator->get(key: 'authentication::messages.uploads.identity-card.success')),
        );
    }
}
