<?php

declare(strict_types=1);

namespace Modules\Residence\Application\UseCases;

use Modules\Shared\Domain\Enums\Http;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\Translation\Translator;
use Modules\Shared\Domain\ValueObjects\Duration;
use Modules\Residence\Domain\UseCases\ResidencesResponse;
use Modules\Residence\Domain\Repositories\ResidenceRepository;
use Modules\Residence\Domain\UseCases\SearchResidences\SearchResidencesRequest;
use Modules\Residence\Domain\UseCases\SearchResidences\SearchResidencesContract;

use function Modules\Shared\Infrastructure\Helpers\string_value;

final readonly class SearchResidences implements SearchResidencesContract
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
    public function execute(SearchResidencesRequest $request): ResidencesResponse
    {
        try {
            $pagination = $this->repository->search(
                page: $request->page,
                key: $request->location,
                stay: new Duration(start: $request->checkin, end: $request->checkout)
            );
        } catch (\Throwable $throwable) {
            $this->exception->report(e: $throwable);

            return new ResidencesResponse(
                failed: true,
                status: Http::INTERNAL_SERVER_ERROR,
                message: string_value(value: $this->translator->get(key: 'shared::messages.errors.server')),
            );
        }

        if ($pagination->items === []) {
            return new ResidencesResponse(
                failed: true,
                status: Http::NOT_FOUND,
                message: string_value(value: $this->translator->get(key: 'residence::messages.search.error')),
            );
        }

        return new ResidencesResponse(
            failed: false,
            status: Http::OK,
            residences: $pagination,
            message: $this->translator->choice(key: 'residence::messages.search.success', number: $pagination->total),
        );
    }
}
