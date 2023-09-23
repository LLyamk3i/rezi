<?php

use function Pest\Laravel\patchJson;

use Illuminate\Support\Facades\Cache;
use function PHPUnit\Framework\assertNotNull;
use Modules\Authentication\Infrastructure\Models\User;
use function Modules\Shared\Infrastructure\Helpers\migrate_authentication;

uses(
    \Tests\TestCase::class,
    \Illuminate\Foundation\Testing\RefreshDatabase::class,
);

it(description: 'can verify user account', closure: function () {
    

    $user = User::factory()->unverified()->create();
    $code = '784-852';
    Cache::set(key: "{$user->email}-one-time-password", value: $code);
    $response = patchJson(uri: '/api/auth/verifications/email', data: [
        'email' => $user->email,
        'code' => $code,
    ]);

    $response->assertJson(value: [
        'success' => true,
        'message' => "Votre compte a bien été vérifié.",
    ]);

    assertNotNull(actual: $user->fresh()->email_verified_at);
});
