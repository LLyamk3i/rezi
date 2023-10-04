<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Forms\Components;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Modules\Residence\Domain\Enums\Media;
use Modules\Admin\Infrastructure\Enums\Libraries\Directories;

final class MediaUpload
{
    /**
     * @param array<int,string> $mimes
     *
     * @return array<int,Field>
     */
    public static function make(
        Media $type,
        Directories $directory,
        bool $named = false,
        bool $required = false,
        array $mimes = []
    ): array {
        $file = FileUpload::make(name: 'path');
        if ($required) {
            $file->required();
        }

        $mimes === [] ? $file->image() : $file->acceptedFileTypes(types: $mimes);

        return array_filter(array: [
            $named ? TextInput::make(name: 'name')->translateLabel()->columnSpan(span: 'full') : null,
            Hidden::make(name: 'type')->default(state: $type->value),
            $file
                ->directory(directory: $directory->value)
                ->columnSpan(span: 'full')
                ->label(label: 'fichier'),
        ]);
    }
}
