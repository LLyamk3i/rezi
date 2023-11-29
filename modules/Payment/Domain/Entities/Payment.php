<?php

declare(strict_types=1);

namespace Modules\Payment\Domain\Entities;

use Modules\Payment\Domain\Enums\Status;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Payment\Domain\ValueObjects\Amount;

final readonly class Payment
{
    public function __construct(
        public Ulid $id,
        public Amount $amount,
        public Ulid $user,
        public Ulid $reservation,
        public Status $status,
        public null | \DateTime $payed,
    ) {
    }
}
