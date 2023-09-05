<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Services\Seeder;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

final class SaveUserRoles
{
    /**
     * @param array<int,array{id:string,email:string,name:string,surname:string,password:string}>                                    $users
     * @param array<string,array{id:string,name:string,created_at:\Illuminate\Support\Carbon,updated_at:\Illuminate\Support\Carbon}> $roles
     */
    public function run(array $users, array $roles): void
    {
        DB::table(table: 'role_user')->insert(values: Arr::flatten(depth: 1, array: array_map(
            array: array_column(array: $users, column_key: 'id'),
            callback: static fn (string $user) => array_map(
                array: collect(value: $roles)->pluck(value: 'id')->toArray(),
                callback: static fn (string $role_id) => ['user_id' => $user, 'role_id' => $role_id],
            )
        )));
    }
}
