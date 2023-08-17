<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Enums\Libraries;

enum Labels: string
{
    case Activated = 'activé';
    case Deactivated = 'désactivé';
    case Path = 'photo';
    case Poster = 'photo ';
    case Geolocate = 'Définir la position actuelle ';
}
