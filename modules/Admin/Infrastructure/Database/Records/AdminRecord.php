<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Database\Records;

/**
 * @phpstan-import-type UserRecord from \Modules\Admin\Infrastructure\Database\Records\OwnerRecord
 */
final class AdminRecord
{
    /**
     * @phpstan-return UserRecord
     */
    public static function data(): array
    {
        return [
            'email' => 'admin@rezi.com',
            'forename' => 'admin',
            'surname' => 'admin',
            'password' => bcrypt(
                value: config(key: 'app.env') === 'production' ? '1INMe5ciws!YctjH2yTcbOL%acf^wwzQ' : 'Pa$$w0rd!'
            ),
        ];
    }
}
