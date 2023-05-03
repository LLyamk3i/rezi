<?php

declare(strict_types=1);

namespace App\Logging;

use Illuminate\Log\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

final class QueryFormatter
{
    public function __invoke(Logger $logger): void
    {
        array_map(array: $logger->getHandlers(), callback: function (StreamHandler $handler): void {
            $handler->setFormatter(formatter: $this->formatter());
        });
    }

    private function formatter(): LineFormatter
    {
        return new LineFormatter(
            format: '[%datetime%] %channel%.%level_name%: %message%' . \PHP_EOL . '-> %context% %extra%' . \PHP_EOL
        );
    }
}
