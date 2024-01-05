<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Models;

use Filament\Panel;
use Filament\Models\Contracts\HasName;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Authentication\Domain\Contracts\VerifyUserAccessManagerContract;

use function Modules\Shared\Infrastructure\Helpers\make_ulid_value;

final class Owner extends Authenticatable implements FilamentUser, HasName
{
    use \Modules\Admin\Infrastructure\Concerns\Model\UserConcern;
    use \Modules\Shared\Infrastructure\Concerns\Model\UserConcern;

    /**
     * @throws \InvalidArgumentException
     */
    public function canAccessPanel(Panel $panel): bool
    {
        /** @var VerifyUserAccessManagerContract $verify */
        $verify = app(abstract: VerifyUserAccessManagerContract::class);

        return $verify->owner(user: make_ulid_value(value: $this->id));
    }
}
