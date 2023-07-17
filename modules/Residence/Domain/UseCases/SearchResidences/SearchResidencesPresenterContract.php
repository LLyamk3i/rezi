<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\UseCases\SearchResidences;

interface SearchResidencesPresenterContract
{
    public function present(SearchResidencesResponse $response): void;
}
