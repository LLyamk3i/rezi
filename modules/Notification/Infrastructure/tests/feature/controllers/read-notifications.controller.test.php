<?php

declare(strict_types=1);

use Illuminate\Testing\Assert;
use Modules\Authentication\Infrastructure\Models\User;

use function Pest\Laravel\actingAs;

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
);

test(description: 'user can mark as read all is notifications', closure: function (): void {
    require_once __DIR__ . '/../../sandbox/WelcomeNewMember.php';
    require_once __DIR__ . '/../../sandbox/InvoicePaid.php';


    $client = User::factory()->create();
    $client->notify(instance: new WelcomeNewMember);
    $client->notify(instance: new InvoicePaid);

    $response = actingAs(user: $client)->deleteJson(uri: '/api/notifications/reads');

    $response->assertOk();
    $response->assertJson(value: [
        'success' => true,
        'message' => 'Toutes vos notifications sont marquées comme lues.',
    ]);

    Assert::assertCount(expectedCount: 2, haystack: $client->notifications);
    Assert::assertCount(expectedCount: 0, haystack: $client->unreadNotifications);
});
