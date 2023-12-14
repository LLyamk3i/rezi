<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Factories;

final class ImageUrlFactory
{
    /**
     * @return array{link:string,usage:string}|null
     */
    public static function make(mixed $path): array | null
    {
        if (\is_string(value: $path)) {
            return [
                'link' => $path,
                'usage' => route(
                    name: 'image.show',
                    parameters: ['h' => 50, 'w' => 50, 'path' => $path]
                ),
            ];
        }

        return null;
    }
}
