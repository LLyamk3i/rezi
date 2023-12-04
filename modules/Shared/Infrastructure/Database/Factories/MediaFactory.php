<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Database\Factories;

use Symfony\Component\Uid\Ulid;
use Modules\Shared\Infrastructure\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Media>
 *
 * @phpstan-type MediaFactoryResponse array{id:string,type:string,disk:string,original:string,collection:string,path:string,mime:string,name:string,hash:string,size:integer,created_at:string,updated_at:string}
 */
final class MediaFactory extends Factory
{
    protected $model = Media::class;

    /**
     * @phpstan-return MediaFactoryResponse
     */
    public function definition(): array
    {
        $id = Ulid::generate();
        $original = $id . '.jpg';

        return [
            'id' => $id,
            'type' => 'image',
            'disk' => 'public',
            'original' => $original,
            'collection' => 'images',
            'created_at' => (string) now(),
            'updated_at' => (string) now(),
            'path' => "path/to/{$original}",
            'mime' => $this->faker->mimeType(),
            'name' => $this->faker->word() . '.jpg',
            'hash' => hash(algo: 'sha256', data: $id),
            'size' => $this->faker->numberBetween(int1: 1000, int2: 9000),
        ];
    }

    public function type(string $value): self
    {
        return $this->state(state: ['type' => $value]);
    }
}
