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
     * @return array<string,<string,string|bool>>|string
     */
    public function run(?string $file = null): array | string
    {
        $manifest = json_decode(
            json: file_get_contents(filename: __DIR__ . '/../../resources/frontend/build/manifest.json'),
            associative: true,
        );

        if ($file) {
            return $manifest[$file]['file'];
        }

        return $manifest;
    }
}
