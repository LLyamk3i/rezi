<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\Glide\ServerFactory;
use Illuminate\Filesystem\FilesystemAdapter;
use League\Glide\Responses\LaravelResponseFactory;

final class ImageController
{
    /**
     * @throws \InvalidArgumentException
     */
    public function show(FilesystemAdapter $filesystem, Request $request, string $path): mixed
    {
        $server = ServerFactory::create(config: [
            'response' => new LaravelResponseFactory(request: $request),
            'source' => $filesystem->getDriver(),
            'cache' => $filesystem->getDriver(),
            'cache_path_prefix' => '.caches',
            'base_url' => 'images',
        ]);

        return $server->getImageResponse(path: $path, params: $request->all());
    }
}
