<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\Repositories;

use Modules\Shared\Domain\ValueObjects\File;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Shared\Domain\Contracts\MediaExistsQueryContract;

interface MediaRepository
{
    /**
     * @param File|array<int|string,File> $media
     */
    public function insert(File | array $media, Ulid $user, string $fileable): bool;

    public function exists(MediaExistsQueryContract $query): bool;
}
