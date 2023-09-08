<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Database\Factories;

use Symfony\Component\Uid\Ulid;
use Modules\Authentication\Domain\Enums\Roles;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Authentication\Infrastructure\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Authentication\Infrastructure\Models\Role>
 *
 * @phpstan-type RoleFactoryResponse array{id:string,name:string,guard:'web',created_at:string,updated_at:string}
 */
final class RoleFactory extends Factory
{
    protected $model = Role::class;

    /**
     * @phpstan-return RoleFactoryResponse
     */
    public function definition()
    {
        return [
            'id' => Ulid::generate(),
            'name' => fake()->word(),
            'guard' => 'web',
            'created_at' => (string) now(),
            'updated_at' => (string) now(),
        ];
    }

    public function client(): self
    {
        return $this->state(state: ['name' => Roles::Client]);
    }

    public function provider(): self
    {
        return $this->count(count: 2)
            ->sequence(['name' => Roles::Client], ['name' => Roles::Provider]);
    }
}
