<?php

declare(strict_types=1);

namespace Modules\Auth\Infrastructure\Database\Seeders;

use Illuminate\Database\Seeder;
use Symfony\Component\Uid\Ulid;
use Modules\Auth\Domain\Contracts\CreateAccountManagerContract;
use Modules\Auth\Infrastructure\Database\Records\ProviderRecord;

class ProviderSeeder extends Seeder
{
    public function __construct(
        private readonly CreateAccountManagerContract $create,
    ) {
        //
    }

    public function run(): void
    {
        $this->create->provider(attributes: [
            ...ProviderRecord::data(),
            'id' => Ulid::generate(),
        ]);
    }
}
