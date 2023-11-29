<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\UseCases\ListResidences;

use Modules\Residence\Domain\UseCases\ResidencesResponse;

interface ListResidencesContract
{
    public function execute(ListResidencesRequest $request): ResidencesResponse;
}
