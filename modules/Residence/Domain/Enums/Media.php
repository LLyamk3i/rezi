<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\Enums;

enum Media: string
{
    use \ArchTech\Enums\Values;

    case Poster = 'poster';
    case Gallery = 'gallery';
    case Icon = 'icon';
}
