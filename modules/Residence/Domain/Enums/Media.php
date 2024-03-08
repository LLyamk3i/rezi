<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\Enums;

enum Media: string
{
    use \ArchTech\Enums\Values;

    case Icon = 'images/icon';
    case Poster = 'images/poster';
    case Avatar = 'images/avatar';
    case Identity = 'images/identity';
    case Gallery = 'images/gallery';
}
