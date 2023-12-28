<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\UseCases;

use Modules\Shared\Domain\Enums\Http;
use Modules\Residence\Domain\Entities\Residence;
use Modules\Shared\Domain\DataTransferObjects\PaginatedObject;

final readonly class ResidencesResponse
{
    /**
     * @param null|PaginatedObject<Residence>|array<int,Residence> $residences
     * @param array<int,string>|null                               $inventory
     */
    public function __construct(
        public Http $status,
        public bool $failed,
        public string $message,
        public array | null $inventory = null,
        public Residence | null $residence = null,
        public PaginatedObject | array | null $residences = null,
    ) {
        //
    }
}
