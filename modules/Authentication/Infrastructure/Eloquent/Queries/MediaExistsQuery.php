<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Eloquent\Queries;

use Illuminate\Support\Facades\DB;
use Modules\Residence\Domain\Enums\Media;
use Modules\Authentication\Infrastructure\Models\User;
use Modules\Shared\Domain\Contracts\MediaExistsQueryContract;

final class MediaIdentityExistsQuery implements MediaExistsQueryContract
{
    public function __construct(
        private readonly string $user
    ) {
        //
    }

    public function execute(): bool
    {
        $counter = DB::table(table: 'media')
            ->where(column: 'fileable_id', operator: '=', value: $this->user)
            ->where(column: 'type', operator: '=', value: Media::Identity->value)
            ->where(column: 'fileable_type', operator: '=', value: (new User())->getMorphClass())
            ->count();

        return $counter === 2;
    }
}
