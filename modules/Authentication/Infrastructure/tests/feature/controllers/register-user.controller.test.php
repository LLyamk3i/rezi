<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Notification;
use Modules\Authentication\Domain\Enums\Roles;
use Modules\Authentication\Infrastructure\Models\User;
use Modules\Authentication\Infrastructure\Notifications\OneTimePassword;
use Modules\Authentication\Infrastructure\Database\Seeders\RoleTableSeeder;

use function Pest\Laravel\postJson;

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
);

it(description: 'can register user', closure: function (): void {
    Notification::fake();
    $data = [
        'forename' => 'test forename',
        'surname' => 'test surname',
        'email' => 'test@example.com',
        'password' => 'password',
        'phone' => fake()->phoneNumber(),
        'password_confirmation' => 'password',
    ];

    RoleTableSeeder::make()->run();

    $response = postJson(uri: '/api/auth/register', data: $data);

    $response->assertCreated();

    $response->assertJson(value: [
        'success' => true,
        'message' => "L'enregistrement a été effectué avec succès. Vous pouvez maintenant vous connecter.",
    ]);

    $user = User::first();

    expect(value: $user->roles->pluck('name')->toArray())->toContain(Roles::Client, Roles::Provider);
    expect(value: $user->forename)->toBe(expected: $data['forename']);
    expect(value: $user->surname)->toBe(expected: $data['surname']);
    expect(value: $user->email)->toBe(expected: $data['email']);
    expect(value: Hash::check(value: $data['password'], hashedValue: $user->password))->toBeTrue();
    Notification::assertSentTo(
        notifiable: [new User(attributes: ['email' => $user->email])],
        notification: OneTimePassword::class
    );
});
