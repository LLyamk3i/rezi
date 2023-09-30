<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Supports;

final class Enum
{
    use \ArchTech\Enums\Values;

    private static string $enum;

    /**
     * @param class-string $enum
     */
    public static function api(string $enum): void
    {
        self::$enum = $enum;
    }

    /**
     * @return array<int,string>
     */
    public static function cases(): array
    {
        return self::$enum::cases();
    }
}
