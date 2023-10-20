<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\Enums;

enum Media: string
{
    use \ArchTech\Enums\Values;

    case Poster = 'images/poster';
    case Gallery = 'images/gallery';
    case Icon = 'images/icon';
}
