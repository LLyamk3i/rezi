<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Eloquent\Repositories;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Modules\Shared\Domain\ValueObjects\File;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Shared\Domain\Contracts\GeneratorContract;
use Modules\Shared\Domain\Repositories\MediaRepository;

use Modules\Shared\Domain\Contracts\MediaExistsQueryContract;

use function Modules\Shared\Infrastructure\Helpers\array_filter_filled;

final readonly class EloquentMediaRepository implements MediaRepository
{
    public function __construct(
        private GeneratorContract $ulid,
    ) {
    }

    /**
     * @param File|array<int|string,File> $media
     */
    public function insert(File | array $media, Ulid $user, string $fileable): bool
    {
        $ulid = $this->ulid;

        return DB::table(table: 'media')->insert(values: array_map(
            array: array_filter_filled(array: Arr::wrap(value: $media)),
            callback: static fn (File $file): array => [
                'id' => $ulid->generate(),
                ...$file->serialize(),
                'fileable_type' => $fileable,
                'fileable_id' => $user->value,
            ]
        ));
    }

    public function exists(MediaExistsQueryContract $query): bool
    {
        return $query->execute();
    }
}
