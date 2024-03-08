<?php

declare(strict_types=1);

use Illuminate\Http\Testing\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemAdapter;
use Modules\Shared\Infrastructure\Models\Media;
use Modules\Authentication\Infrastructure\Models\User;
use Modules\Residence\Domain\Enums\Media as EnumsMedia;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
);

test(description: 'user can upload identity card', closure: function (): void {
    Storage::fake(disk: $disk = config(key: 'app.upload.disk'));

    $user = User::factory()->verified()->create();
    $document = 'cni';
    $card = [
        'card_recto' => UploadedFile::fake()->image(name: 'card.recto.jpg', width: 500),
        'card_verso' => UploadedFile::fake()->image(name: 'card.verso.jpg'),
    ];

    $response = actingAs(user: $user)->postJson(uri: '/api/auth/upload/identity-card', data: [
        ...$card,
        'document_type' => $document,
    ]);

    $response->assertJson(value: [
        'success' => true,
        'message' => trans(key: 'authentication::messages.uploads.identity-card.success'),
    ]);

    array_walk(array: $card, callback: function (File $file) use ($disk, $user, $document): void {
        $path = 'users/identity-cards/' . $file->hashName();

        tap(value: Storage::disk(name: $disk), callback: function (FilesystemAdapter $storage) use ($path): void {
            $storage->assertExists(path: $path);
        });

        assertDatabaseHas(table: 'media', data: [
            'path' => $path,
            'size' => $file->getSize(),
            'fileable_id' => $user->id,
            'name' => $file->getClientOriginalName(),
            'collection' => "identity-cards/{$document}",
            'mime' => $file->getClientMimeType(),
            'disk' => config(key: 'app.upload.disk'),
            'fileable_type' => $user->getMorphClass(),
            'original' => $file->hashName(),
            'hash' => hash_file(
                algo: config(key: 'app.upload.hash'),
                filename: with(
                    value: Storage::disk(name: $disk),
                    callback: static fn (FilesystemAdapter $filesystem): string => $filesystem->path(path: $path)
                ),
            ),
        ]);
    });
});

test(description: 'user cannot upload identity card twice', closure: function (): void {

    $user = User::factory()->verified()->create();
    Media::factory()->type(value: EnumsMedia::Identity->value)->for(factory: $user, relationship: 'fileable')->create();

    $response = actingAs(user: $user)->postJson(uri: '/api/auth/upload/identity-card', data: [
        'document_type' => 'passeport',
        'card_recto' => UploadedFile::fake()->image(name: 'card.recto.jpg', width: 500),
    ]);

    $response->assertJson(value: [
        'success' => false,
        'message' => trans(key: 'authentication::messages.uploads.identity-card.errors.exists'),
    ]);
});
