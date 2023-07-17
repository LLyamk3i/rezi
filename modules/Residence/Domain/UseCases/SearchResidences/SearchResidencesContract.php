<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\UseCases\SearchResidences;

interface SearchResidencesContract
{
    public function execute(SearchResidencesRequest $request, SearchResidencesPresenterContract $presenter): void;
}
