<?php

use Filament\Support\Assets\Asset;
use Illuminate\Support\Arr;
use Laravel\Sanctum\Sanctum;
use Illuminate\Testing\Assert;

use function Pest\Laravel\postJson;
use function Pest\Laravel\deleteJson;
use function PHPUnit\Framework\assertCount;
use Modules\Authentication\Infrastructure\Models\User;

uses(
    \Tests\TestCase::class,
    \Illuminate\Foundation\Testing\RefreshDatabase::class,
);

test(description: 'user can login', closure: function (): void {

    $user = User::factory()->avatar()->create();

    $response = postJson(uri: '/api/auth/login', data: [
        'email' => $user->email,
        'device' => 'test',
        'password' => 'password',
    ]);

    $response->assertOk();

    $response->assertJson(value: [
        'success' => true,
        'message' => "L'utilisateur s'est connecté avec succès.",
    ]);

    $response->assertJsonPath(path: 'client', expect: function (array $client) use ($user): bool {
        Assert::assertTrue(condition: is_string(value: Arr::get(array: $client, key: 'avatar.usage')));
        Assert::assertTrue(condition: is_string(value: Arr::get(array: $client, key: 'avatar.link')));
        Assert::assertSame(expected: $user->id, actual: $client['id']);
        Assert::assertSame(expected: $user->forename, actual: $client['forename']);
        Assert::assertSame(expected: $user->email, actual: $client['email']);
        return true;
    });
});

test(description: 'users can not authenticate with invalid password', closure: function (): void {
    $user = User::factory()->create();

    $response = postJson(uri: '/api/auth/login', data: [
        'email' => $user->email,
        'device' => 'test',
        'password' => 'wrong-password',
    ]);
    $response->assertJsonValidationErrors(errors: [
        'email' => "Les informations d'identification fournies sont incorrectes."
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
