<?php

declare(strict_types=1);

namespace Modules\Auth\Domain\DataTransferObjects;

use Modules\Auth\Domain\Enums\Roles;

final class RolesGroupsObject
{
    /**
     * @return array<int,Roles>
     */
    public function owner(): array
    {
        return [Roles::Owner, ...$this->admin()];
    }

    /**
     * @return array<int,Roles>
     */
    public function admin(): array
    {
        return [Roles::Admin, ...$this->provider()];
    }

    /**
     * @return array<int,Roles>
     */
    public function provider(): array
    {
        return [Roles::Provider, Roles::Client, Roles::Guest];
    }
}
