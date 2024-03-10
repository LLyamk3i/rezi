<?php

declare(strict_types=1);

use Illuminate\Testing\Assert;
use Modules\Authentication\Infrastructure\Models\User;

use function Pest\Laravel\actingAs;

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
);

test(description: 'user can mark as read a notification', closure: function (): void {
    require_once __DIR__ . '/../../sandbox/WelcomeNewMember.php';
    require_once __DIR__ . '/../../sandbox/InvoicePaid.php';


    $client = User::factory()->create();
    $client->notify(instance: new WelcomeNewMember);
    $client->notify(instance: new InvoicePaid);

    $notifications = $client->notifications;

    $response = actingAs(user: $client)->deleteJson(uri: '/api/notifications/reads/' . $notifications->first()->id);

    $response->assertOk();
    $response->assertJson(value: [
        'success' => true,
        'message' => "Notification #{$notifications->first()->id} marqué comme lue.",
    ]);

    Assert::assertCount(expectedCount: 2, haystack: $notifications);
    Assert::assertCount(expectedCount: 1, haystack: $client->unreadNotifications);
});
