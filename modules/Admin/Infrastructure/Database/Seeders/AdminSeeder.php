<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Infrastructure\Database\Records\AdminRecord;
use Modules\Auth\Infrastructure\Managers\CreateAccountManager;

class AdminSeeder extends Seeder
{
    public function __construct(
        private readonly CreateAccountManager $manager,
    ) {
        //
    }

    public function run(): void
    {
        $this->manager->admin(attributes: [
            ...AdminRecord::data(),
            'password' => config(key: 'app.env') === 'production'
                ? bcrypt(value: '1INMe5ciws!YctjH2yTcbOL%acf^wwzQ')
                : 'Pa$$w0rd!',
        ]);
    }
}
