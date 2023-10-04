<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Models\Attributes;

use Modules\Residence\Infrastructure\Models\Residence;

use function Modules\Shared\Infrastructure\Helpers\boolean_value;

final readonly class VisibleAttribute
{
    public function __construct(
        private Residence $residence,
    ) {
        //
    }

    public function value(): bool
    {
        return boolean_value($this->residence->getAttribute(key: 'visible'));
    }

    public function toggle(): void
    {
        $this->residence->update(attributes: [
            'visible' => ! boolean_value(value: $this->residence->getAttribute(key: 'visible')),
        ]);
    }
}
