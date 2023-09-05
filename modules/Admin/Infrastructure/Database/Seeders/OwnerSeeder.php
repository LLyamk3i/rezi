<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Infrastructure\Database\Records\OwnerRecord;
use Modules\Shared\Infrastructure\Services\Seeder\SaveUserRoles;
use Modules\Shared\Infrastructure\Services\Seeder\CreateUsersService;

final class OwnerSeeder extends Seeder
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
     * @return array{owners:array<int,array{id:string,email:string,name:string,surname:string,password:string}>}
     */
    public function run(array $roles, int $count, bool $persiste): array
    {
        $owners = $this->users->run(count: $count, basic: [OwnerRecord::data()]);

        if ($persiste) {
            DB::table(table: 'users')->insert(values: $owners);
            $this->save->run(users: $owners, roles: $roles);
        }

        return ['owners' => $owners];
    }
}
