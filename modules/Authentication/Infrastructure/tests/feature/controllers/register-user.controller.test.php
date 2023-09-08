<?php

use function Pest\Laravel\postJson;
use Illuminate\Support\Facades\Hash;
use Modules\Authentication\Domain\Enums\Roles;

use Modules\Authentication\Infrastructure\Models\User;
use Modules\Authentication\Infrastructure\Database\Seeders\RoleTableSeeder;

uses(
    \Tests\TestCase::class,
    \Illuminate\Foundation\Testing\LazilyRefreshDatabase::class,
);

it(description: 'can register user', closure: function () {
    $data = [
        'forename' => 'test forename',
        'surname' => 'test surname',
        'email' => 'test@example.com',
        'password' => 'password',
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
});
