<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;

final class WelcomeController
{
    /**
     * @return array{message: string, data: array{service: string, version: string, language: string, support: mixed}}
     */
    public function __invoke(Application $app, Repository $config): array
    {
        return [
            'message' => 'Welcome to OPEN API',
            'data' => [
                'service' => 'OPEN API',
                'version' => '0.0.1',
                'language' => $app->getLocale(),
                'support' => $config->get(key: 'mail.from.address'),
            ],
        ];
    }
}
