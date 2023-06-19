<?php

declare(strict_types=1);

namespace Modules\Auth\Infrastructure\Database\Factories;

use Illuminate\Support\Str;
use Modules\Auth\Infrastructure\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Auth\Infrastructure\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Define the model's default state.s
     *
     * @return array{name:string,email:string,email_verified_at:\Illuminate\Support\Carbon,password:string,remember_token:string}
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'surname' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(state: ['email_verified_at' => null]);
    }
}
