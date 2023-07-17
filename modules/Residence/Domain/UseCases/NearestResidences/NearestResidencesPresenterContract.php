<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\UseCases\NearestResidences;

interface NearestResidencesPresenterContract
{
    public function present(NearestResidencesResponse $response): void;
}
