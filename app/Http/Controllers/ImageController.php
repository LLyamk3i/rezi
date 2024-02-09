<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\Glide\ServerFactory;
use Modules\Shared\Domain\Enums\Http;
use Illuminate\Contracts\Filesystem\Filesystem;
use League\Glide\Responses\LaravelResponseFactory;
use Modules\Shared\Infrastructure\Services\ImagePathVerificationService;

final class ImageController
{
    public function __construct(
        private readonly Filesystem $filesystem,
        private readonly ImagePathVerificationService $service,
    ) {
        //
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function show(Request $request, string $path): mixed
    {

        $path = $this->service->run(path: $path);

        if (\is_null(value: $path)) {
            abort(code: Http::NOT_FOUND->value);
        }

        $server = ServerFactory::create(config: [
            'response' => new LaravelResponseFactory(request: $request),
            'source' => with(value: $this->filesystem)->getDriver(),
            'cache' => with(value: $this->filesystem)->getDriver(),
            'cache_path_prefix' => '.caches',
            'base_url' => 'images',
        ]);

        return $server->getImageResponse(path: $path, params: $request->all());
    }
}
