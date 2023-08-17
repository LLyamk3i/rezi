<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Resources\ResidenceResource\Fields;

use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use Modules\Admin\Infrastructure\Enums\Libraries\Labels;

final class LocationField
{
    public static function make(): Map
    {
        return Map::make(name: 'location')
            ->defaultLocation(location: [5.1892604473931, -3.9852047386115])
            ->defaultZoom(8)
            ->geolocate()
            ->geolocateLabel(geolocateLabel: Labels::Geolocate->value)
            ->required()
            ->translateLabel()
            ->columnSpan(span: 'full');
    }
}
