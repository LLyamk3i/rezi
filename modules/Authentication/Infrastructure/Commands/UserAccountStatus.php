<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Commands;

use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Authentication\Infrastructure\Models\User;
use Modules\Shared\Domain\Repositories\MediaRepository;
use Modules\Authentication\Infrastructure\Eloquent\Queries\MediaIdentityExistsQuery;

use function Modules\Shared\Infrastructure\Helpers\string_value;

final class UserAccountStatus
{
    public function __construct(
        private readonly MediaRepository $media,
    ) {
        //
    }

    /**
     * @return array{otp:bool,identity:bool}
     */
    public function handle(User $user): array
    {
        return [
            'otp' => ! \is_null(value: $user->getAttribute(key: 'email_verified_at')),
            'identity' => $this->media->exists(query: new MediaIdentityExistsQuery(
                user: new Ulid(value: string_value(value: $user->getAttribute(key: 'id')))
            )),
        ];
    }
}
