<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\UseCases\NearestResidences;

final class NearestResidencesResponse
{
    private bool $failed;

    /**
     * @var array<int,\Modules\Residence\Domain\Entities\Residence>
     */
    private array $residences = [];

    public function setFailed(bool $value): void
    {
        $this->failed = $value;
    }

    /**
     * @param array<int,\Modules\Residence\Domain\Entities\Residence> $value
     */
    public function setResidences(array $value): void
    {
        $this->residences = $value;
    }

    /**
     * @return array<int,\Modules\Residence\Domain\Entities\Residence>
     */
    public function residences(): array
    {
        return $this->residences;
    }

    public function failed(): bool
    {
        return $this->failed;
    }

    public function message(): string
    {
        return $this->failed
            ? "Aucune résidence proche n'a été trouvée pour l'adresse demandée."
            : "Les résidences proches pour l'adresse demandée ont été trouvées.";
    }
}
