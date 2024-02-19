<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Shared\Resources\ResidenceResource\Fields;

use Illuminate\Support\Facades\File;
use Filament\Forms\Components\Fieldset;
use Illuminate\Support\Facades\Storage;
use Modules\Residence\Domain\Enums\Media;
use Modules\Admin\Infrastructure\Enums\Libraries\Directories;
use Modules\Admin\Infrastructure\Filament\Shared\Forms\Components\MediaUpload;

use function Modules\Shared\Infrastructure\Helpers\string_value;

final class PosterField
{
    /**
     * @throws \InvalidArgumentException
     */
    public static function make(): Fieldset
    {
        return Fieldset::make(label: 'photo')
            ->relationship(name: 'poster')
            ->mutateRelationshipDataBeforeCreateUsing(callback: self::mutate())
            ->mutateRelationshipDataBeforeSaveUsing(callback: self::mutate())
            ->schema(components: MediaUpload::make(
                type: Media::Poster,
                directory: Directories::Residence,
                required: true,
                mimes: ['image/jpeg', 'image/jpg', 'image/png'],
            ));
    }

    private static function mutate(): \Closure
    {
        return static function (array $data): array {
            /** @var \Illuminate\Filesystem\FilesystemAdapter $storage */
            $storage = Storage::disk(name: $disk = string_value(value: config(key: 'app.upload.disk')));
            $path = $storage->path(path: string_value(value: $data['path']));
            $name = File::basename(path: $path);

            return [
                ...$data,
                'disk' => $disk,
                'name' => $name,
                'original' => $name,
                'size' => File::size(path: $path),
                'mime' => File::mimeType(path: $path),
                'hash' => File::hash(path: $path, algorithm: string_value(value: config(key: 'app.upload.hash'))),
            ];
        };
    }
}
