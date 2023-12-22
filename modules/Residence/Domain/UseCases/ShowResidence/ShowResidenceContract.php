<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\UseCases\ShowResidence;

use Modules\Residence\Domain\UseCases\ResidencesResponse;

interface ShowResidenceContract
{
    public function execute(ShowResidenceRequest $request): ResidencesResponse;
}
