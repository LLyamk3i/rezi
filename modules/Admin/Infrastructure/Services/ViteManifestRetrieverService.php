<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Services;

final class ViteManifestRetrieverService
{
    public static function make(): self
    {
        return new self();
    }

    /**
     * @return array<string,array<string,string|bool>>|string|null
     */
    public function run(?string $file = null): array | string | null
    {
        $json = file_get_contents(filename: __DIR__ . '/../../resources/frontend/build/manifest.json');

        if (! \is_string(value: $json)) {
            return null;
        }

        $manifest = json_decode(json: $json, associative: true);

        if (! \is_array(value: $manifest)) {
            return null;
        }

        if (\is_string(value: $file)) {
            return $manifest[$file]['file'];
        }

        return $manifest;
    }
}
