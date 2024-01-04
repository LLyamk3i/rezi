<?php

declare(strict_types=1);

use Illuminate\Support\Arr;
use Illuminate\Testing\Assert;
use Modules\Reservation\Domain\Enums\Status;
use Modules\Shared\Infrastructure\Models\Media;
use Modules\Residence\Domain\ValueObjects\Location;
use Modules\Residence\Infrastructure\Models\Rating;
use Modules\Residence\Infrastructure\Models\Feature;
use Modules\Authentication\Infrastructure\Models\User;
use Modules\Residence\Infrastructure\Models\Residence;
use Modules\Shared\Infrastructure\Factories\ImageUrlFactory;

use function Pest\Laravel\getJson;
use function Pest\Laravel\actingAs;
use function Modules\Shared\Infrastructure\Helpers\route as r;
use function Modules\Shared\Infrastructure\Helpers\using_sqlite;

uses(
    \Tests\TestCase::class,
    \Illuminate\Foundation\Testing\RefreshDatabase::class,
);

it(description: 'can list all residences', closure: function (): void {
    Residence::factory()->invisible()->create();
    $residences = Residence::factory()->owner()->visible()->count(count: 5)->create();

    $response = getJson(uri: 'api/residences');
    $response->assertOk();

    $response->assertJson(value: [
        'success' => true,
        'message' => 'La récupération des résidences a été effectuée avec succès.',
    ]);

    $response->assertJsonCount(count: $residences->count(), key: 'residences.items');
});

it(description: 'can paginate residences', closure: function (): void {
    $total = 10;
    $page = ['per' => 3, 'current' => 2, 'last' => (int) ceil(num: $total / 3)];
    $residences = Residence::factory()->count(count: $total)->visible()->poster()->owner()->create();
    $ids = $residences->forPage(page: $page['current'], perPage: $page['per'])->pluck(value: 'id');

    $response = getJson(uri: r(
        path: 'api/residences',
        queries: ['page' => $page['current'], 'per_page' => $page['per']]
    ));

    $response->assertOk();
    $response->assertJson(value: [
        'success' => true,
        'message' => 'La récupération des résidences a été effectuée avec succès.',
        'residences' => ['total' => $total, 'page' => $page],
    ]);

    $response->assertJsonPath(path: 'residences.items', expect: static function (array $residences) use ($ids): bool {
        collect(value: $residences)->each(callback: static function (array $residence) use ($ids): void {
            Assert::assertTrue(condition: \is_string(value: Arr::get(array: $residence, key: 'poster.link')));
            Assert::assertTrue(condition: \is_string(value: Arr::get(array: $residence, key: 'poster.usage')));
            Assert::assertTrue(condition: \is_string(value: Arr::get(array: $residence, key: 'owner.id')));
            Assert::assertTrue(condition: \is_string(value: Arr::get(array: $residence, key: 'owner.name')));
            Assert::assertTrue(condition: $ids->contains(key: $residence['id']));
        });

        return true;
    });
});

test(description: 'fetch residence details without favorite', closure: function (): void {
    Residence::factory()->create();
    $location = new Location(latitude: 0.13, longitude: 1.23);
    $residence = Residence::factory()
        ->visible()
        ->location(value: $location)
        ->reservations(count: 5)
        ->features(count: 3)
        ->type(name: 'duplex')
        ->ratings(count: 2)
        ->views(count: $view = 5)
        ->gallery()
        ->poster()
        ->owner()
        ->create();

    $response = getJson(uri: "api/residences/{$residence->id}");
    $response->assertOk();

    $response->assertJson(value: [
        'success' => true,
        'message' => "Les détails de la résidence #{$residence->id} ont été récupérés avec succès.",
        'residence' => [
            'id' => $residence->id,
            'favoured' => false,
            'view' => $view,
            'name' => $residence->name,
            'rent' => ['value' => $residence->rent, 'format' => number_format(num: $residence->rent, thousands_separator: ' ') . ' Franc CFA'],
            'address' => $residence->address,
            'description' => $residence->description,
            'rooms' => $residence->rooms,
            'poster' => ImageUrlFactory::make(path: $residence->poster->path),
            'note' => $residence->ratings->average(callback: 'value'),
            'owner' => [
                'id' => $residence->provider->id,
                'name' => $residence->provider->name,
                'avatar' => route(name: 'image.show', parameters: ['path' => $residence->provider->avatar->path, 'h' => 50, 'w' => 50]),
            ],
            'type' => [
                'id' => $residence->type->id,
                'name' => $residence->type->name,
            ],
            'location' => [
                'latitude' => using_sqlite() ? 0 : $location->latitude,
                'longitude' => using_sqlite() ? 0 : $location->longitude,
            ],
            'gallery' => $residence->gallery
                ->map(callback: static fn (Media $media): string => route(name: 'image.show', parameters: ['path' => $media->path]))
                ->toArray(),
            'features' => $residence->features
                ->map(callback: static fn (Feature $feature): array => [
                    'id' => $feature->id,
                    'name' => $feature->name,
                    'icon' => route(
                        name: 'image.show',
                        parameters: ['path' => $feature->icon->path]
                    ),
                ])
                ->toArray(),
            'reservations' => $residence->reservations()
                ->where(column: 'status', operator: '=', value: Status::CONFIRMED->value)
                ->get(columns: ['id', 'checkin_at as start', 'checkout_at as end'])
                ->toArray(),
            'ratings' => $residence->ratings()
                ->with(relations: ['owner:id,forename,surname', 'owner.avatar'])
                ->get(columns: ['id', 'value', 'user_id', 'comment', 'created_at'])
                ->map(callback: static fn (Rating $rating): array => [
                    ...$rating->makeHidden(attributes: ['user_id'])->toArray(),
                    'owner' => [
                        'id' => $rating->owner->id,
                        'name' => $rating->owner->name,
                        'avatar' => route(name: 'image.show', parameters: ['path' => $rating->owner?->avatar?->path, 'h' => 50, 'w' => 50]),
                    ],
                ])
                ->toArray(),
        ],
    ]);
});

test(description: 'fetch residence details with favorite', closure: function (): void {

    $client = User::factory()->create();
    $residence = Residence::factory()
        ->visible()
        ->type(name: 'duplex')
        ->favoured(client: $client)
        ->owner()
        ->create();

    $response = actingAs(user: $client)->getJson(uri: "api/residences/{$residence->id}");

    $response->assertOk();

    $response->assertJson(value: [
        'success' => true,
        'message' => "Les détails de la résidence #{$residence->id} ont été récupérés avec succès.",
        'residence' => [
            'id' => $residence->id,
            'favoured' => true,
        ],
    ]);
});
