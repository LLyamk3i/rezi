<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Factories;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemAdapter;
use Modules\Shared\Domain\ValueObjects\File;

use function Modules\Shared\Infrastructure\Helpers\string_value;

final class FileFactory
{
    /**
     * @throws \InvalidArgumentException
     */
    public function make(UploadedFile $file, string $path, string $disk, string $collection): File
    {
        return new File(
            path: $path,
            disk: $disk,
            size: $file->getSize(),
            name: $file->hashName(),
            collection: $collection,
            mime: $file->getClientMimeType(),
            original: $file->getClientOriginalName(),
            hash: hash_file(
                algo: string_value(value: config(key: 'app.upload.hash')),
                filename: string_value(
                    value: with(
                        value: Storage::disk(name: $disk),
                        callback: static fn (FilesystemAdapter $filesystem): string => $filesystem->path(path: $path)
                    )
                ),
            ),
        );
    }
}
