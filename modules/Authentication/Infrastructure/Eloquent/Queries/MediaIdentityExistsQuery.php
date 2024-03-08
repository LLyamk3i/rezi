<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Eloquent\Queries;

use Illuminate\Support\Facades\DB;
use Modules\Residence\Domain\Enums\Media;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Authentication\Infrastructure\Models\User;
use Modules\Authentication\Domain\Contracts\MediaIdentityExistsQueryContract;

final class MediaIdentityExistsQuery implements MediaIdentityExistsQueryContract
{
    public function __construct(
        private readonly Ulid $user,
    ) {
        //
    }

    public function execute(): bool
    {
        $counter = DB::table(table: 'media')
            ->where(column: 'fileable_id', operator: '=', value: $this->user->value)
            ->where(column: 'type', operator: '=', value: Media::Identity->value)
            ->where(column: 'fileable_type', operator: '=', value: (new User())->getMorphClass())
            ->count();

        return \in_array(needle: $counter, haystack: [1, 2]);
    }
}
