<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Database\Records;

final class ProviderRecord
{
    /**
     * @return array{array{email:string,name:string,surname:string,password:string}}
     */
    public static function data(): array
    {
        return [
            [
                'email' => 'davon.provider@resi.com',
                'forename' => 'davon',
                'surname' => 'romaguera',
                'password' => bcrypt(value: 'Pa$$w0rd!'),
            ], [
                'email' => 'kobe.provider@resi.com',
                'forename' => 'kobe',
                'surname' => 'stroman',
                'password' => bcrypt(value: 'Pa$$w0rd!'),
            ],
        ];
    }
}
