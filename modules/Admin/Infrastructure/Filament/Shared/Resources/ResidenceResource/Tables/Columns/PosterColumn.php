<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Shared\Resources\ResidenceResource\Tables\Columns;

use Filament\Tables\Columns\ImageColumn;
use Modules\Admin\Infrastructure\Enums\Libraries\Labels;

use function Modules\Shared\Infrastructure\Helpers\string_value;

final class PosterColumn
{
    /**
     * @throws \InvalidArgumentException
     */
    public static function make(): ImageColumn
    {
        return ImageColumn::make(name: 'poster.path')
            ->toggleable()
            ->disk(disk: string_value(value: config(key: 'app.upload.disk')))
            ->label(label: Labels::Poster->value);
    }
}
