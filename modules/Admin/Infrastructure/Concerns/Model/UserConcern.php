<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Concerns\Model;

trait UserConcern
{
    public function getFilamentName(): string
    {
        return $this->getAttribute(key: 'forename') . ' ' . $this->getAttribute(key: 'surname');
    }
}
