<?php

declare(strict_types=1);

namespace Modules\Auth\Infrastructure\Database\Records;

final class ProviderRecord
{
    /**
     * @return array{email:string,name:string,surname:string,password:string}
     */
    public static function data(): array
    {
        return [
            'email' => 'provider@resi.com',
            'name' => 'provider',
            'surname' => 'provider',
            'password' => 'Pa$$w0rd!',
        ];
    }
}
