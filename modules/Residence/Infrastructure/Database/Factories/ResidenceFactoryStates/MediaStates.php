<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Database\Factories\ResidenceFactoryStates;

use Modules\Shared\Infrastructure\Models\Media;
use Modules\Residence\Domain\Enums\Media as EnumsMedia;

trait MediaStates
{
    public function poster(): self
    {
        return $this->has(
            relationship: 'poster',
            factory: Media::factory()->type(value: EnumsMedia::Poster->value),
        );
    }

    public function gallery(): self
    {
        return $this->has(
            relationship: 'gallery',
            factory: Media::factory()->count(count: rand(min: 1, max: 5))->type(value: EnumsMedia::Gallery->value),
        );
    }
}
