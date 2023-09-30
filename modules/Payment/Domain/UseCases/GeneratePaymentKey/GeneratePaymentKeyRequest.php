<?php

declare(strict_types=1);

namespace Modules\Payment\Domain\UseCases\GeneratePaymentKey;

use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Payment\Domain\ValueObjects\Amount;
use Modules\Authentication\Domain\Entities\User;

final readonly class GeneratePaymentKeyRequest
{
    public function __construct(
        public Amount $amount,
        public Ulid $reservation,
        public User $client,
    ) {
        //
    }
}
