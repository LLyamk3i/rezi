<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\UseCases\NearestResidences;

interface NearestResidencesContract
{
    public function execute(NearestResidencesRequest $request, NearestResidencesPresenterContract $presenter): void;
}
