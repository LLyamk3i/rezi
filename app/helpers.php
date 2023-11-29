<?php

declare(strict_types=1);

(static function (): void {
    $files = [
        'modules/Shared/Application/Helpers/values.php',
        'modules/Shared/Infrastructure/Helpers/test.php',
        'modules/Shared/Application/Helpers/factories.php',
        'modules/Shared/Infrastructure/Helpers/commons.php',
        'modules/Shared/Infrastructure/Helpers/database.php',
        'modules/Shared/Infrastructure/Helpers/instances.php',
    ];

    foreach ($files as $file) {
        require_once __DIR__ . "/../{$file}";
    }
})();
