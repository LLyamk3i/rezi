<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\Enums;

enum Media: string
{
    use \ArchTech\Enums\Values;

    case Poster = 'poster';
    case Gallery = 'gallery';
}
