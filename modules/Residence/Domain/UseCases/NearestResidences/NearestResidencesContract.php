<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\UseCases\NearestResidences;

use Modules\Residence\Domain\UseCases\ResidencesResponse;

interface NearestResidencesContract
{
    public function execute(NearestResidencesRequest $request): ResidencesResponse;
}
