<?php

declare(strict_types=1);

use Illuminate\Testing\Assert;
use Modules\Authentication\Infrastructure\Models\User;

use function Pest\Laravel\actingAs;

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
);

it(description: 'show user notifications', closure: function (): void {
    require_once __DIR__ . '/../../sandbox/WelcomeNewMember.php';
    require_once __DIR__ . '/../../sandbox/InvoicePaid.php';

    [$client, $other] = User::factory()->count(count: 2)->create();
    $client->notify(instance: new WelcomeNewMember);
    $other->notify(instance: new InvoicePaid);

    $response = actingAs(user: $client)->getJson(uri: '/api/notifications');

    $response->assertOk();
    $response->assertJson(value: [
        'success' => true,
        'message' => 'Voici vos notifications.',
    ]);

    $response->assertJsonPath(path: 'notifications', expect: static function (array $results): bool {
        Assert::assertCount(expectedCount: 1, haystack: $results);
        Assert::assertSame(expected: WelcomeNewMember::class, actual: $results[0]['type']);

        return true;
    });
});
