<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Database\Factories;

use Illuminate\Support\Str;
use Symfony\Component\Uid\Ulid;
use Modules\Shared\Infrastructure\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Authentication\Infrastructure\Models\User;
use Modules\Residence\Domain\Enums\Media as EnumsMedia;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Authentication\Infrastructure\Models\User>
 *
 * @phpstan-type UserFactoryResponse array{id:string,forename:string,surname:string,email:string,email_verified_at:string,password:string,remember_token:string,created_at:string,updated_at:string}
 */
final class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * @phpstan-return UserFactoryResponse
     *
     * @throws \OverflowException
     */
    public function definition(): array
    {
        return [
            'id' => Ulid::generate(),
            'forename' => fake()->firstName(),
            'surname' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => (string) now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'created_at' => (string) now(),
            'updated_at' => (string) now(),
        ];
    }

    public function avatar(): self
    {
        return $this->has(
            relationship: 'avatar',
            factory: Media::factory()->type(value: EnumsMedia::Avatar->value),
        );
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(state: ['email_verified_at' => null]);
    }

    public function verified(): static
    {
        return $this->state(state: ['email_verified_at' => (string) now()]);
    }
}
