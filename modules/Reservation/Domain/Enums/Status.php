<?php

declare(strict_types=1);

namespace Modules\Reservation\Domain\Enums;

enum Status: string
{
    use \ArchTech\Enums\Values;

    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
    case CANCELLED = 'cancelled';
    case COMPLETED = 'completed';
}
