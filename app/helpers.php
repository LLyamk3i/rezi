<?php

declare(strict_types=1);

(static function (): void {
    $files = [
        'modules/Shared/Infrastructure/Helpers/Commons.php',
        'modules/Shared/Infrastructure/Helpers/Instances.php',
        'modules/Shared/Infrastructure/Helpers/Tests.php',
        'modules/Shared/Application/Helpers/Values.php',
        'modules/Shared/Application/Helpers/Factories.php',
    ];

    foreach ($files as $file) {
        require_once __DIR__ . "/../{$file}";
    }
})();
