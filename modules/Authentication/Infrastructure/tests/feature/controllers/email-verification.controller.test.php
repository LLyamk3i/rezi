<?php

use function Pest\Laravel\patchJson;

use Illuminate\Support\Facades\Cache;
use function PHPUnit\Framework\assertNotNull;
use Modules\Authentication\Infrastructure\Models\User;
use function Modules\Shared\Infrastructure\Helpers\migrate_authentication;

uses(\Tests\SqliteTestCase::class);

it(description: 'can verify user account', closure: function () {
    migrate_authentication();

    $user = User::factory()->unverified()->create();
    $code = '784-852';
    Cache::set(key: "{$user->email}-one-time-password", value: $code);
    $response = patchJson(uri: '/api/auth/email/verification', data: [
        'id' => $user->id,
        'code' => $code,
    ]);

    $response->assertJson(value: [
        'success' => true,
        'message' => "Votre compte a bien été vérifié.",
    ]);

    assertNotNull(actual: $user->fresh()->email_verified_at);
});
