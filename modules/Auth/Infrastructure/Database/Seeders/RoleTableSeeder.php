<?php

declare(strict_types=1);

namespace Modules\Auth\Infrastructure\Database\Seeders;

use Illuminate\Database\Seeder;
use Symfony\Component\Uid\Ulid;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Domain\Enums\Roles;

class RoleTableSeeder extends Seeder
{
    use \Illuminate\Database\Console\Seeds\WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table(table: 'roles')
            ->insert(values: array_map(
                callback: static fn (string $role): array => ['id' => Ulid::generate(), 'name' => $role],
                array: Roles::values()
            ));
    }
}
