<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Services\Seeder;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 * @phpstan-import-type RoleFactoryResponse from \Modules\Authentication\Infrastructure\Database\Factories\RoleFactory
 * @phpstan-import-type UserFactoryResponse from \Modules\Authentication\Infrastructure\Database\Factories\UserFactory
 */
final class SaveUserRoles
{
    /**
     * @phpstan-param array<int,UserFactoryResponse> $users
     * @phpstan-param array<string,RoleFactoryResponse> $roles
     */
    public function run(array $users, array $roles): void
    {
        DB::table(table: 'role_user')->insert(values: Arr::flatten(depth: 1, array: array_map(
            array: array_column(array: $users, column_key: 'id'),
            callback: static fn (string $user): array => array_map(
                array: collect(value: $roles)->pluck(value: 'id')->toArray(),
                callback: static fn (string $role_id): array => ['user_id' => $user, 'role_id' => $role_id],
            )
        )));
    }
}
