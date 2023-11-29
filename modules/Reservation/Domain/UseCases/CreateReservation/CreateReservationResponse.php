<?php

declare(strict_types=1);

namespace Modules\Reservation\Domain\UseCases\CreateReservation;

final class CreateReservationResponse
{
    private bool $failed;

    private null | string $message = null;

    public function setFailed(bool $value): void
    {
        $this->failed = $value;
    }

    public function setMessage(string $value): void
    {
        $this->message = $value;
    }

    public function failed(): bool
    {
        return $this->failed;
    }

    public function message(): string
    {
        if (! \is_null(value: $this->message)) {
            return $this->message;
        }

        if ($this->failed) {
            return 'Impossible de créer la réservation. Veuillez vérifier les informations fournies et réessayer.';
        }

        return 'Unknown error';
    }
}
