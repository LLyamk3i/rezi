<?php

declare(strict_types=1);

use Illuminate\Support\Arr;
use Illuminate\Testing\Assert;
use Illuminate\Support\Facades\DB;
use Modules\Reservation\Domain\Enums\Status;
use Modules\Shared\Infrastructure\Models\Media;
use Modules\Residence\Domain\ValueObjects\Location;
use Modules\Residence\Infrastructure\Models\Feature;
use Modules\Residence\Infrastructure\Models\Residence;
use Modules\Shared\Infrastructure\Factories\ImageUrlFactory;

use function Pest\Laravel\getJson;
use function Modules\Shared\Infrastructure\Helpers\using_sqlite;
use function Modules\Shared\Infrastructure\Helpers\array_filter_filled;

uses(
    \Tests\TestCase::class,
    \Illuminate\Foundation\Testing\RefreshDatabase::class,
);

it(description: 'can list all residences', closure: function (): void {
    DB::table(table: 'residences')->truncate();
    Residence::factory()->invisible()->create();
    $residences = Residence::factory()->visible()->count(count: 5)->create();

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
    $page = ['max' => 3, 'current' => 2];

    DB::table(table: 'residences')->truncate();
    $residences = Residence::factory()->visible()->poster()->owners(count: 3)->count(count: $total)->create();
    $ids = $residences->forPage(page: $page['current'], perPage: $page['max'])->pluck(value: 'id');

    $response = getJson(uri: 'api/residences?' . http_build_query(data: ['page' => $page['current'], 'per_page' => $page['max']]));

    $response->assertOk();
    $response->assertJson(value: [
        'success' => true,
        'message' => 'La récupération des résidences a été effectuée avec succès.',
        'residences' => [
            'total' => $total,
            'page' => [
                'per' => $page['max'],
                'current' => $page['current'],
                'last' => (int) ceil(num: $total / $page['max']),
            ],
        ],
    ]);

    // dd($response->json());

    $response->assertJsonPath(path: 'residences.items', expect: function (array $residences) use ($ids): bool {
        collect(value: $residences)->each(callback: function (array $residence) use ($ids): void {
            Assert::assertTrue(condition: \is_string(value: Arr::get(array: $residence, key: 'poster.link')));
            Assert::assertTrue(condition: \is_string(value: Arr::get(array: $residence, key: 'poster.usage')));
            Assert::assertTrue(condition: \is_string(value: Arr::get(array: $residence, key: 'owner.id')));
            Assert::assertTrue(condition: \is_string(value: Arr::get(array: $residence, key: 'owner.name')));
            Assert::assertTrue(condition: $ids->contains(key: $residence['id']));
        });

        return true;
    });
});

test(description: 'fetch residence details', closure: function (): void {

    Residence::factory()->create();
    $location = new Location(latitude: 0.13, longitude: 1.23);
    $residence = Residence::factory()
        ->visible()
        ->location(value: $location)
        ->reservations(count: 5)
        ->features(count: 3)
        ->type(name: 'duplex')
        ->ratings(count: 2)
        ->gallery()
        ->poster()
        ->owner()
        ->create();

    $response = getJson(uri: "api/residences/{$residence->id}");

    // file_put_contents(
    //     filename: base_path(path: 'trash/details.json'),
    //     data: json_encode(value: $response->json(), flags: \JSON_PRETTY_PRINT | \JSON_UNESCAPED_SLASHES)
    // );

    $response->assertOk();

    // dd($response->json());

    return;

    $response->assertJson(value: array_filter_filled(array: [
        'success' => true,
        'message' => 'La récupération de la résidence  a été effectuée avec succès.',
        'message' => "Les détails de la résidence #{$residence->id} ont été récupérés avec succès.",
        'residence' => [
            'id' => $residence->id,
            'name' => $residence->name,
            'rent' => $residence->rent,
            'address' => $residence->address,
            'description' => $residence->description,
            'rooms' => $residence->rooms,
            'poster' => ImageUrlFactory::make(path: $residence->poster->path),
            'note' => $residence->ratings->average(callback: 'value'),
            'owner' => [
                'id' => $residence->provider->id,
                'name' => $residence->provider->name,
                'avatar' => $residence->provider->avatar->path,
            ],
            'type' => [
                'id' => $residence->type->id,
                'name' => $residence->type->name,
            ],
            'location' => [
                'latitude' => using_sqlite() ? 0 : $location->latitude,
                'longitude' => using_sqlite() ? 0 : $location->longitude,
            ],
            'ratings' => $residence->ratings->only(keys: ['value', 'comment'])->toArray(),
            'gallery' => $residence->gallery
                ->map(callback: fn (Media $media): string => route(name: 'image.show', parameters: ['path' => $media->path]))
                ->toArray(),
            'features' => $residence->features
                ->map(callback: fn (Feature $feature): array => [
                    'id' => $feature->id,
                    'name' => $feature->name,
                    'icon' => route(name: 'image.show', parameters: ['path' => $feature->icon->path]),
                ])
                ->toArray(),
            'reservations' => $residence
                ->reservations()
                ->where(column: 'status', operator: '=', value: Status::CONFIRMED->value)
                ->get(columns: ['checkin_at', 'checkout_at'])
                ->toArray(),
        ],
    ]));
});
