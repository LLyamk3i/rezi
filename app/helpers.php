<?php

declare(strict_types=1);

(static function (): void {
    $files = [
        'modules/Shared/Infrastructure/Helpers/Commons.php',
        'modules/Shared/Infrastructure/Helpers/Instances.php',
        'modules/Shared/Infrastructure/Helpers/Values.php',
    ];

    foreach ($files as $file) {
        require_once __DIR__ . "/../{$file}";
    }
})();
