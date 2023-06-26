<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Foundation\Console\AboutCommand;

final class ApplicationDependenciesService
{
    public static function context(): void
    {
        $about = require resource_path(path: 'about/index.php');

        array_walk(
            array: $about,
            callback: static function (array $content, string $title): void {
                AboutCommand::add(section: $title, data: static fn (): array => $content);
            }
        );
    }
}
