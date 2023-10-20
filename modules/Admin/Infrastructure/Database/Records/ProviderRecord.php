<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Database\Records;

/**
 * @phpstan-import-type UserRecord from \Modules\Admin\Infrastructure\Database\Records\OwnerRecord
 */
final class ProviderRecord
{
    /**
     * @phpstan-return array<int,UserRecord>
     */
    public static function data(): array
    {
        return [
            [
                'email' => 'davon.provider@rezi.com',
                'forename' => 'davon',
                'surname' => 'romaguera',
                'password' => bcrypt(value: 'Pa$$w0rd!'),
            ], [
                'email' => 'kobe.provider@rezi.com',
                'forename' => 'kobe',
                'surname' => 'stroman',
                'password' => bcrypt(value: 'Pa$$w0rd!'),
            ],
        ];
    }
}
