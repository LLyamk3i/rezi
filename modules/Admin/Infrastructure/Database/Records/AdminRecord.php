<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Database\Records;

final class AdminRecord
{
    /**
     * @return array{email:string,name:string,surname:string,password:string}
     */
    public static function data(): array
    {
        return [
            'email' => 'admin@resi.com',
            'name' => 'admin',
            'surname' => 'admin',
            'password' => 'Pa$$w0rd!',
        ];
    }
}
