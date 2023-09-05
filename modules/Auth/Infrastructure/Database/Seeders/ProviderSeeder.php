<?php

declare(strict_types=1);

namespace Modules\Auth\Infrastructure\Database\Seeders;

use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Domain\Enums\Roles;
use Modules\Shared\Infrastructure\Services\Seeder\SaveUserRoles;
use Modules\Admin\Infrastructure\Database\Records\ProviderRecord;
use Modules\Shared\Infrastructure\Services\Seeder\CreateUsersService;

final class ProviderSeeder extends Seeder
{
    use \Illuminate\Database\Console\Seeds\WithoutModelEvents;

    public function __construct(
        private readonly CreateUsersService $users,
        private readonly SaveUserRoles $save,
    ) {
        //
    }

    /**
     * @param array<string,array{id:string,name:string,created_at:\Illuminate\Support\Carbon,updated_at:\Illuminate\Support\Carbon}> $roles
     *
     * @return array{providers:array<int,array{id:string,email:string,name:string,surname:string,password:string}>}
     */
    public function run(array $roles, int $count, bool $persiste): array
    {
        $providers = $this->users->run(count: $count, basic: ProviderRecord::data());
        if ($persiste) {
            DB::table(table: 'users')->insert(values: $providers);

            $this->save->run(
                users: $providers,
                roles: Arr::except(array: $roles, keys: [Roles::Owner->value, Roles::Admin->value])
            );
        }

        return ['providers' => $providers];
    }
}
