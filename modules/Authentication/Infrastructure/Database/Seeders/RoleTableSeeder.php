<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Database\Seeders;

use Illuminate\Database\Seeder;
use Symfony\Component\Uid\Ulid;
use Illuminate\Support\Facades\DB;
use Modules\Authentication\Domain\Enums\Roles;

/**
 * @phpstan-import-type RoleFactoryResponse from \Modules\Authentication\Infrastructure\Database\Factories\RoleFactory
 */
final class RoleTableSeeder extends Seeder
{
    use \Illuminate\Database\Console\Seeds\WithoutModelEvents;

    public static function make(): static
    {
        return new self();
    }

    /**
     * @phpstan-return array{roles:array<string,RoleFactoryResponse>}
     */
    public function run(bool $persiste = true): array
    {
        $basic = Roles::values();

        $roles = array_combine(
            keys: $basic,
            values: array_map(array: $basic, callback: static fn (string $role): array => [
                'id' => Ulid::generate(),
                'name' => $role,
                'guard' => 'web',
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
