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
        return [Roles::OWNER, ...$this->admin()];
    }

    /**
     * @return array<int,Roles>
     */
    public function admin(): array
    {
        return [Roles::ADMIN, ...$this->provider()];
    }

    /**
     * @return array<int,Roles>
     */
    public function provider(): array
    {
        return [Roles::PROVIDER, Roles::CLIENT, Roles::GUEST];
    }
}
