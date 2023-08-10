<?php

declare(strict_types=1);

namespace Modules\Auth\Infrastructure\Database\Records;

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
                'name' => 'davon',
                'surname' => 'romaguera',
                'password' => 'Pa$$w0rd!',
            ], [
                'email' => 'kobe.provider@resi.com',
                'name' => 'kobe',
                'surname' => 'stroman',
                'password' => 'Pa$$w0rd!',
            ],
        ];
    }
}
