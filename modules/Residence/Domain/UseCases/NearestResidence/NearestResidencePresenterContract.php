<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\UseCases\NearestResidence;

interface NearestResidencePresenterContract
{
    public function present(NearestResidenceResponse $response): void;
}
