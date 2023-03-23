<?php

namespace App\Services;

use Illuminate\Foundation\Console\AboutCommand;

class ApplicationDependenciesService
{
    public static function context(): void
    {
        $about = require base_path(path: 'templates/about/index.php');

        array_walk(
            array: $about,
            callback: static function (array $content, string $title): void {
                AboutCommand::add(section: $title, data: static fn () => $content);
            }
        );
    }
}
