<?php

use function Pest\Laravel\postJson;
use function Pest\Laravel\deleteJson;
use function PHPUnit\Framework\assertCount;

use Laravel\Sanctum\Sanctum;
use Modules\Authentication\Infrastructure\Models\User;

uses(\Tests\SqliteTestCase::class);

test(description: 'user can login', closure: function () {

    $user = User::factory()->create();

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
});

test(description: 'users can not authenticate with invalid password', closure: function () {
    $user = User::factory()->create();

    $response = postJson(uri: '/api/auth/login', data: [
        'email' => $user->email,
        'device' => 'test',
        'password' => 'wrong-password',
    ]);
    $response->assertJsonValidationErrors(errors: ['email' => 'The provided credentials are incorrect.']);
});

test(description: 'users can logout', closure: function () {
    $user = User::factory()->create();
    Sanctum::actingAs(user: $user);

    $response = deleteJson(uri: '/api/auth/logout', data: [
        'email' => $user->email,
        'device' => 'test',
        'password' => 'wrong-password',
    ]);

    $response->assertOk();

    assertCount(expectedCount: 0, haystack: $user->tokens);

    // Assert the JSON response
    $response->assertJson(value: [
        'success' => true,
        'message' => 'Utilisateur déconnecté.',
    ]);
});
