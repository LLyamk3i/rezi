<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Provider\Resources;

use Modules\Admin\Infrastructure\Filament\Shared\Resources\ResidenceResource as ParentResource;

final class ResidenceResource extends ParentResource
{
    /**
     * @return array<string,\Filament\Resources\Pages\PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            ...parent::getPages(),
            'index' => ResidenceResource\Pages\ListResidences::route(path: '/'),
        ];
    }
}
