<?php

declare(strict_types=1);

use Illuminate\Support\Arr;
use Laravel\Sanctum\Sanctum;
use Illuminate\Testing\Assert;

use Modules\Authentication\Infrastructure\Models\User;

use function Pest\Laravel\postJson;
use function Pest\Laravel\deleteJson;
use function PHPUnit\Framework\assertCount;

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
);

test(description: 'user can login', closure: function ($access): void {
    $user = User::factory()->state(state: $access)->avatar()->create();

    $response = postJson(uri: '/api/auth/login', data: [
        ...$access,
        'device' => 'test',
        'password' => 'password',
    ]);

    $response->assertOk();

    $response->assertJson(value: [
        'success' => true,
        'message' => "L'utilisateur s'est connecté avec succès.",
    ]);

    $response->assertJsonPath(path: 'verified', expect: static function (array $verified): bool {
        Assert::assertIsBool(actual: $verified['otp']);
        Assert::assertIsBool(actual: $verified['identity']);

        return true;
    });
    $response->assertJsonPath(path: 'client', expect: static function (array $client) use ($user): bool {
        Assert::assertIsString(actual: Arr::get(array: $client, key: 'avatar.usage'));
        Assert::assertIsString(actual: Arr::get(array: $client, key: 'avatar.link'));
        Assert::assertSame(expected: $user->id, actual: $client['id']);
        Assert::assertSame(expected: $user->forename, actual: $client['forename']);
        Assert::assertSame(expected: $user->email, actual: $client['email']);

        return true;
    });
})->with(data: [
    'phone' => fn () => ['phone' => fake()->phoneNumber()],
    'email' => fn () => ['email' => fake()->safeEmail()],
]);

test(description: 'users can not authenticate with invalid password', closure: function (): void {
    $user = User::factory()->create();

    $response = postJson(uri: '/api/auth/login', data: [
        'email' => $user->email,
        'device' => 'test',
        'password' => 'wrong-password',
    ]);
    $response->assertJsonValidationErrors(errors: [
        'email' => "Les informations d'identification fournies sont incorrectes.",
    ]);
});

test(description: 'users can logout', closure: function (): void {
    $user = User::factory()->create();
    Sanctum::actingAs(user: $user);

    $response = deleteJson(uri: '/api/auth/logout', data: [
        'email' => $user->email,
        'device' => 'test',
        'password' => 'wrong-password',
    ]);

    $response->assertOk();

    assertCount(expectedCount: 0, haystack: $user->tokens);

    $response->assertJson(value: [
        'success' => true,
        'message' => 'Utilisateur déconnecté.',
    ]);
});
