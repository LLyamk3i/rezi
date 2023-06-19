<?php

use function Pest\Laravel\postJson;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Domain\Enums\Roles;

use Modules\Auth\Infrastructure\Models\User;
use Modules\Auth\Infrastructure\Database\Seeders\RoleTableSeeder;

uses(
    \Tests\TestCase::class,
    \Illuminate\Foundation\Testing\LazilyRefreshDatabase::class,
);

it(description: 'can register user', closure: function () {
    $data = [
        'name' => 'Test User',
        'surname' => 'Test User name',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    (new RoleTableSeeder())->run();

    $response = postJson(uri: '/api/auth/register', data: $data);

    $response->assertCreated();

    $response->assertJson(value: [
        'success' => true,
        'message' => "L'enregistrement a été effectué avec succès. Vous pouvez maintenant vous connecter.",
    ]);

    $user = User::first();

    expect(value: $user->roles->pluck('name')->toArray())->toContain(Roles::CLIENT, Roles::PROVIDER);
    expect(value: $user->name)->toBe(expected: $data['name']);
    expect(value: $user->surname)->toBe(expected: $data['surname']);
    expect(value: $user->email)->toBe(expected: $data['email']);
    expect(value: Hash::check(value: $data['password'], hashedValue: $user->password))->toBeTrue();
});
