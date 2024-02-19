<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\Glide\ServerFactory;
use Modules\Shared\Domain\Enums\Http;
use Illuminate\Filesystem\FilesystemAdapter;
use League\Glide\Responses\LaravelResponseFactory;
use Modules\Shared\Infrastructure\Services\ImagePathVerificationService;

final class ImageController
{
    public function __construct(
        private readonly FilesystemAdapter $filesystem,
        private readonly ImagePathVerificationService $service,
    ) {
        //
    }

    /**
     * @throws \RuntimeException
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
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
            'source' => $this->filesystem->getDriver(),
            'cache' => $this->filesystem->getDriver(),
            'cache_path_prefix' => '.caches',
            'base_url' => config(key: 'app.setting.image.url'),
        ]);

        return $server->getImageResponse(path: $path, params: $request->all());
    }
}
