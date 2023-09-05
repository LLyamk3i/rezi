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
            'forename' => 'admin',
            'surname' => 'admin',
            'password' => bcrypt(
                value: config(key: 'app.env') === 'production' ? '1INMe5ciws!YctjH2yTcbOL%acf^wwzQ' : 'Pa$$w0rd!'
            ),
        ];
    }
}
