<?php

declare(strict_types=1);

namespace Modules\Residence\Application\UseCases;

use Modules\Shared\Domain\Enums\Http;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\Translation\Translator;
use Modules\Residence\Domain\UseCases\ResidencesResponse;
use Modules\Residence\Domain\Repositories\ResidenceRepository;
use Modules\Residence\Domain\UseCases\NearestResidences\NearestResidencesRequest;
use Modules\Residence\Domain\UseCases\NearestResidences\NearestResidencesContract;

use function Modules\Shared\Infrastructure\Helpers\string_value;

final readonly class NearestResidences implements NearestResidencesContract
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
    public function execute(NearestResidencesRequest $request): ResidencesResponse
    {
        try {
            $residences = $this->repository->nearest(radius: $request->radius, location: $request->location);

        } catch (\Throwable $throwable) {
            $this->exception->report(e: $throwable);

            return new ResidencesResponse(
                failed: true,
                status: Http::INTERNAL_SERVER_ERROR,
                message: string_value(value: $this->translator->get(key: 'shared::messages.errors.server')),
            );
        }

        if ($residences === []) {
            return new ResidencesResponse(
                failed: true,
                status: Http::BAD_REQUEST,
                message: string_value(value: $this->translator->get(key: 'residence::messages.nearest.error')),
            );
        }

        return new ResidencesResponse(
            failed: false,
            status: Http::OK,
            residences: $residences,
            inventory: ['id', 'name', 'address', 'location', 'distance'],
            message: $this->translator->choice(key: 'residence::messages.nearest.success', number: \count(value: $residences)),
        );
    }
}
