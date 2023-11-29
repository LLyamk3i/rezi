<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\UseCases\ListResidences;

use Modules\Shared\Domain\ValueObjects\Pagination\Page;

final readonly class ListResidencesRequest
{
    public function __construct(public Page $page)
    {
        //
    }
}
