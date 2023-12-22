<?php

declare(strict_types=1);

namespace Modules\Residence\Application\UseCases;

use Modules\Shared\Domain\Enums\Http;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\Translation\Translator;
use Modules\Residence\Domain\UseCases\ResidencesResponse;
use Modules\Residence\Domain\Repositories\ResidenceRepository;
use Modules\Residence\Domain\UseCases\ShowResidence\ShowResidenceRequest;
use Modules\Residence\Domain\UseCases\ShowResidence\ShowResidenceContract;

use function Modules\Shared\Infrastructure\Helpers\string_value;

final readonly class ShowResidence implements ShowResidenceContract
{
    public function __construct(
        private Translator $translator,
        private ExceptionHandler $exception,
        private ResidenceRepository $repository,
    ) {
        //
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function execute(ShowResidenceRequest $request): ResidencesResponse
    {
        try {
            $residence = $this->repository->find(id: $request->residence);
        } catch (\Throwable $throwable) {
            $this->exception->report(e: $throwable);

            return new ResidencesResponse(
                failed: true,
                status: Http::INTERNAL_SERVER_ERROR,
                message: string_value(value: $this->translator->get(key: 'shared::messages.errors.server')),
            );
        }

        if (\is_null(value: $residence)) {
            return new ResidencesResponse(
                failed: true,
                status: Http::BAD_REQUEST,
                message: string_value(value: $this->translator->get(
                    key: 'residence::messages.details.error',
                    replace: ['id' => $request->residence->value],
                )),
            );
        }

        return new ResidencesResponse(
            failed: false,
            status: Http::OK,
            residence: $residence,
            message: string_value(value: $this->translator->get(
                key: 'residence::messages.details.success',
                replace: ['id' => $request->residence->value],
            )),
        );
    }
}
