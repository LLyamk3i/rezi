<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Database\Records;

final class OwnerRecord
{
    /**
     * @return array{email:string,name:string,surname:string,password:string}
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
