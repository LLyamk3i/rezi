<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\UseCases\SearchResidences;

use Modules\Residence\Domain\UseCases\ResidencesResponse;

interface SearchResidencesContract
{
    public function execute(SearchResidencesRequest $request): ResidencesResponse;
}
