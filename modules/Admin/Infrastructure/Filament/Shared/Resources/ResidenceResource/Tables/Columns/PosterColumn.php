<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Shared\Resources\ResidenceResource\Tables\Columns;

use Filament\Tables\Columns\ImageColumn;
use Modules\Admin\Infrastructure\Enums\Libraries\Labels;

final class PosterColumn
{
    public static function make(): ImageColumn
    {
        return ImageColumn::make(name: 'poster.path')
            ->toggleable()
            ->disk(disk: config(key: 'app.upload.disk'))
            ->label(label: Labels::Poster->value);
    }
}
