<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\Contracts;

use Modules\Residence\Domain\UseCases\NearestResidence\NearestResidenceResponse;

interface NearestResidencePresenterContract
{
    public function present(NearestResidenceResponse $response): void;
}
