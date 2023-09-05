<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Resources\ResidenceResource\Tables\Columns;

use Illuminate\Support\Facades\Storage;
use Modules\Admin\Infrastructure\Enums\Libraries\Labels;
use Filament\Tables\Columns\ImageColumn as FilamentImageColumn;

final class ImageColum
{
    public static function make(): FilamentImageColumn
    {
        return FilamentImageColumn::make(name: 'poster.path')
            ->label(label: Labels::Poster->value)
            ->defaultImageUrl(url: Storage::url(path: '/icons/undraw_house_searching_re_stk8.svg'))
            ->toggleable();
    }
}
