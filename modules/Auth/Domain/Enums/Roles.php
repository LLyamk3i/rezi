<?php

declare(strict_types=1);

namespace Modules\Auth\Domain\Enums;

enum Roles: string
{
    use \ArchTech\Enums\Values;

    case Owner = 'owner';
    case Admin = 'admin';
    case Provider = 'provider';
    case Client = 'client';
    case Guest = 'guest';
}
