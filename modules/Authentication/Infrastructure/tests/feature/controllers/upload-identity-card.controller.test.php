<?php

use Illuminate\Http\Testing\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemAdapter;
use Modules\Authentication\Infrastructure\Models\User;

use function Modules\Shared\Infrastructure\Helpers\string_value;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

uses(
    \Tests\TestCase::class,
    \Illuminate\Foundation\Testing\RefreshDatabase::class,
);

it(description: 'can save and register uploaded user identity card', closure: function (): void {
    Storage::fake(disk: $disk = config(key: 'app.upload.disk'));

    $user = User::factory()->verified()->create();
    $card = [
        'recto' =>  UploadedFile::fake()->image(name: 'card.recto.jpg', width: 500),
        'verso' =>  UploadedFile::fake()->image(name: 'card.verso.jpg'),
    ];

    $response = actingAs(user: $user)->postJson(uri: '/api/auth/upload/identity-card', data: ['card' => $card]);

    $response->assertJson(value: [
        'success' => true,
        'message' => trans(key: 'authentication::messages.uploads.identity-card.success'),
    ]);

    array_walk(array: $card, callback: function (File $file) use ($disk, $user): void {
        $path = 'users/identity-cards/' . $file->hashName();
        
        tap(value: Storage::disk(name: $disk), callback: function (FilesystemAdapter $storage) use ($path): void {
            $storage->assertExists(path: $path);
        });

        assertDatabaseHas(table: 'media', data: [
            'path' => $path,
            'size'=> $file->getSize(),
            'fileable_id' => $user->id,
            'name' => $file->hashName(),
            'collection' => 'identity-cards',
            'mime' => $file->getClientMimeType(),
            'disk' => config(key: 'app.upload.disk'),
            'fileable_type' => $user->getMorphClass(),
            'original' => $file->getClientOriginalName(),
            'hash' => hash_file(
                algo: config(key: 'app.upload.hash'),
                filename: string_value(
                    value: with(
                        value: Storage::disk(name: $disk),
                        callback: static fn (FilesystemAdapter $filesystem): string => $filesystem->path(path: $path)
                    )
                ),
            ),
        ]);
    });
});
