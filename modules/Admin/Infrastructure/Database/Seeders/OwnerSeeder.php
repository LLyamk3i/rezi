<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Infrastructure\Database\Records\OwnerRecord;
use Modules\Shared\Infrastructure\Services\Seeder\SaveUserRoles;
use Modules\Shared\Infrastructure\Services\Seeder\CreateUsersService;

/**
 * @phpstan-import-type UserFactoryResponse from \Modules\Authentication\Infrastructure\Database\Factories\UserFactory
 * @phpstan-import-type RoleFactoryResponse from \Modules\Authentication\Infrastructure\Database\Factories\RoleFactory
 */
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
     * @phpstan-param array<string,RoleFactoryResponse> $roles
     *
     * @phpstan-return array{owners:array<int,UserFactoryResponse>}
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
