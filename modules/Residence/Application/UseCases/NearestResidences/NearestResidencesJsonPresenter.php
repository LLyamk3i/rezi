<?php

declare(strict_types=1);

namespace Modules\Residence\Application\UseCases\NearestResidences;

use Modules\Residence\Domain\UseCases\NearestResidences\NearestResidencesResponse;
use Modules\Residence\Domain\UseCases\NearestResidences\NearestResidencesPresenterContract;

final class NearestResidencesJsonPresenter implements NearestResidencesPresenterContract
{
    private NearestResidencesJsonViewModel $view;

    public function present(NearestResidencesResponse $response): void
    {
        $this->view = new NearestResidencesJsonViewModel(
            status: $response->failed() ? 400 : 200,
            success: ! $response->failed(),
            message: $response->message(),
            data: $response->residences(),
        );
    }

    public function view(): NearestResidencesJsonViewModel
    {
        return $this->view;
    }
}
