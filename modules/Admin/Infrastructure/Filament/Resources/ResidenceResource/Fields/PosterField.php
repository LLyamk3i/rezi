<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Resources\ResidenceResource\Fields;

use Filament\Forms\Components\Fieldset;
use Modules\Residence\Domain\Enums\Media;
use Modules\Admin\Infrastructure\Enums\Libraries\Directories;
use Modules\Admin\Infrastructure\Filament\Forms\Components\MediaUpload;

final class PosterField
{
    public static function make(): Fieldset
    {
        return Fieldset::make(label: 'photo')
            ->relationship(relationshipName: 'poster')
            ->schema(components: MediaUpload::make(
                type: Media::Poster,
                directory: Directories::Residence,
                required: true,
            ));
    }
}
