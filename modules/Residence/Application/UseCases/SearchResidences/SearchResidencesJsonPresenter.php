<?php

declare(strict_types=1);

namespace Modules\Residence\Application\UseCases\SearchResidences;

use Modules\Residence\Domain\UseCases\SearchResidences\SearchResidencesResponse;
use Modules\Residence\Domain\UseCases\SearchResidences\SearchResidencesPresenterContract;

final class SearchResidencesJsonPresenter implements SearchResidencesPresenterContract
{
    private SearchResidencesJsonViewModel $viewModel;

    public function present(SearchResidencesResponse $response): void
    {
        $this->viewModel = new SearchResidencesJsonViewModel(
            status: $response->failed ? 400 : 200,
            success: ! $response->failed,
            message: $response->message,
            total: \count(value: $response->residences),
            data: $response->residences,
        );
    }

    public function json(): SearchResidencesJsonViewModel
    {
        return $this->viewModel;
    }
}
