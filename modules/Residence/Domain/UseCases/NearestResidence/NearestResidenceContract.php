<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\UseCases\NearestResidence;

use Modules\Residence\Domain\Contracts\NearestResidencePresenterContract;

interface NearestResidenceContract
{
    public function execute(NearestResidenceRequest $request, NearestResidencePresenterContract $presenter): void;
}
