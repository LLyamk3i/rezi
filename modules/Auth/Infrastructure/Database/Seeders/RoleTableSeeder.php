<?php

declare(strict_types=1);

namespace Modules\Auth\Infrastructure\Database\Seeders;

use Illuminate\Database\Seeder;
use Symfony\Component\Uid\Ulid;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Domain\Enums\Roles;

final class RoleTableSeeder extends Seeder
{
    use \Illuminate\Database\Console\Seeds\WithoutModelEvents;

    /**
     * @return array{roles:array<array{id:string,name:string,created_at:string,updated_at:string}>}
     */
    public function run(bool $persiste): array
    {
        $basic = Roles::values();

        $roles = array_combine(
            keys: $basic,
            values: array_map(array: $basic, callback: static fn (string $role): array => [
                'id' => Ulid::generate(),
                'name' => $role,
                'created_at' => (string) now(),
                'updated_at' => (string) now(),
            ])
        );

        if ($persiste) {
            DB::table(table: 'roles')->insert(values: $roles);
        }

        return ['roles' => $roles];
    }
}
