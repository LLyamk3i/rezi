<?php

declare(strict_types=1);

namespace Modules\Residence\Application\Presenters;

use Modules\Residence\Domain\Contracts\NearestResidencePresenterContract;
use Modules\Residence\Application\ViewModels\NearestResidenceJsonViewModel;
use Modules\Residence\Domain\UseCases\NearestResidence\NearestResidenceResponse;

class NearestResidenceJsonPresenter implements NearestResidencePresenterContract
{
    private NearestResidenceJsonViewModel $view;

    public function present(NearestResidenceResponse $response): void
    {
        $this->view = new NearestResidenceJsonViewModel(
            status: $response->failed() ? 400 : 200,
            success: ! $response->failed(),
            message: $response->message(),
            data: $response->residences(),
        );
    }

    public function view(): NearestResidenceJsonViewModel
    {
        return $this->view;
    }
}
