<?php

declare(strict_types=1);

namespace Modules\Auth\Infrastructure\Database\Factories;

use Modules\Auth\Domain\Enums\Roles;
use Modules\Auth\Infrastructure\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Auth\Infrastructure\Models\Role>
 */
class RoleFactory extends Factory
{
    protected $model = Role::class;

    /**
     * @return array<string,string>
     */
    public function definition()
    {
        return [
            'name' => fake()->word(),
            'guard' => 'web',
        ];
    }

    public function client(): self
    {
        return $this->state(state: ['name' => Roles::CLIENT]);
    }

    public function provider(): self
    {
        return $this->count(count: 2)
            ->sequence(['name' => Roles::CLIENT], ['name' => Roles::PROVIDER]);
    }
}
