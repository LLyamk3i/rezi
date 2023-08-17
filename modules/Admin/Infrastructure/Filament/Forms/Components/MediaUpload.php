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
     * @return array<int,Field>
     */
    public static function make(
        Media $type,
        Directories $directory,
        bool $named = false,
        bool $required = false
    ): array {
        $field = FileUpload::make(name: 'path');
        if ($required) {
            $field->required();
        }

        return array_filter(array: [
            $named ? TextInput::make(name: 'name')->translateLabel()->columnSpan(span: 'full') : null,
            Hidden::make(name: 'type')->default(state: $type->value),
            $field
                ->directory(directory: $directory->value)
                ->columnSpan(span: 'full')
                ->label(label: 'fichier'),
        ]);
    }
}
