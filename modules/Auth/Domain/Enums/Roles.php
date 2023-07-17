<?php

declare(strict_types=1);

namespace Modules\Auth\Domain\Enums;

enum Roles: string
{
    use \ArchTech\Enums\Values;

    case OWNER = 'owner';
    case ADMIN = 'admin';
    case PROVIDER = 'provider';
    case CLIENT = 'client';
    case GUEST = 'guest';
}
