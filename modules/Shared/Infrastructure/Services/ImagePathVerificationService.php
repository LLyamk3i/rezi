<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Services;

use Illuminate\Support\Facades\File;

final class ImagePathVerificationService
{
    /**
     * @return void
     *
     * @throws \RuntimeException
     */
    public function run(string $path): string | null
    {
        if (File::exists(path: storage_path(path: "app/private/{$path}"))) {
            return "private/{$path}";
        }
        if (File::exists(path: storage_path(path: "app/public/{$path}"))) {
            return "public/{$path}";
        }

        return null;
    }
}
