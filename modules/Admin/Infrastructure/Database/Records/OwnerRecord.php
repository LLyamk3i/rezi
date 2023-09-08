<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Database\Records;

/**
 * @phpstan-type UserRecord array{email:string,forename:string,surname:string,password:string}
 */
final class OwnerRecord
{
    /**
     * @phpstan-return UserRecord
     */
    public static function data(): array
    {
        return [
            'email' => 'owner@resi.com',
            'forename' => 'owner',
            'surname' => 'owner',
            'password' => bcrypt(
                value: config(key: 'app.env') === 'production' ? 'ctjH25ciws!YbOL%acf^wwzQyTc1INMe' : 'Pa$$w0rd!'
            ),
        ];
    }
}
