<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Eloquent\Repositories;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Modules\Shared\Domain\ValueObjects\File;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Shared\Domain\Contracts\GeneratorContract;
use Modules\Shared\Domain\Repositories\MediaRepository;

final readonly class EloquentMediaRepository implements MediaRepository
{
    public function __construct(
        private GeneratorContract $ulid,
    ) {
    }

    /**
     * @param File|array<int|string,File> $media
     */
    public function insert(File | array $media, Ulid $user, string $context): void
    {
        $ulid = $this->ulid;

        DB::table(table: 'media')->insert(values: array_map(
            array: Arr::wrap($media),
            callback: static fn (File $file): array => [
                'id' => $ulid->generate(),
                ...$file->toArray(),
                'fileable_type' => $context,
                'fileable_id' => $user->value,
            ]
        ));
    }
}
