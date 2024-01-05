<?php

declare(strict_types=1);

use Modules\Authentication\Infrastructure\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
);

test(description: 'update user account', closure: function (): void {
    $user = User::factory()->create();

    $data = [
        'emergency_contact' => fake()->phoneNumber(),
        'forename' => fake()->name(),
        'surname' => fake()->lastName(),
        'address' => fake()->address(),
    ];

    $response = actingAs(user: $user)->patchJson(uri: 'api/auth/profile', data: $data);

    $response->assertOk();

    $response->assertJson(value: [
        'success' => true,
        'message' => 'Votre profil a été mis à jour avec succès.',
    ]);

    assertDatabaseHas(table: 'users', data: [
        'id' => $user->getKey(),
        'email' => $user->email,
        ...$data,
    ]);
});
