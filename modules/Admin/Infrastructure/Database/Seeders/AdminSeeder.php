<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Database\Seeders;

use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Domain\Enums\Roles;
use Modules\Admin\Infrastructure\Database\Records\AdminRecord;
use Modules\Shared\Infrastructure\Services\Seeder\SaveUserRoles;
use Modules\Shared\Infrastructure\Services\Seeder\CreateUsersService;

final class AdminSeeder extends Seeder
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
     * @return array{admins:array<int,array{id:string,email:string,name:string,surname:string,password:string}>}
     */
    public function run(array $roles, int $count, bool $persiste): array
    {
        $admins = $this->users->run(count: $count, basic: [AdminRecord::data()]);
        if ($persiste) {
            DB::table(table: 'users')->insert(values: $admins);

            $this->save->run(
                users: $admins,
                roles: Arr::except(array: $roles, keys: [Roles::Owner->value])
            );
        }

        return ['admins' => $admins];
    }
}
