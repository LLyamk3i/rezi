<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\UseCases\NearestResidence;

interface NearestResidenceContract
{
    public function execute(NearestResidenceRequest $request, NearestResidencePresenterContract $presenter): void;
}
