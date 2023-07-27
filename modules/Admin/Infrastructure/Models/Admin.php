<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Models;

use Modules\Auth\Domain\Enums\Roles;
use Filament\Models\Contracts\FilamentUser;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Auth\Domain\Contracts\VerifyUserAccessManagerContract;

final class Admin extends Authenticatable implements FilamentUser
{
    use \Illuminate\Database\Eloquent\Concerns\HasUlids;

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var array<int,string>
     */
    protected $guarded = ['id', 'email_verified_at', 'created_at', 'updated_at'];

    /**
     * @var array<int,string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * @var array<string,string>
     */
    protected $casts = ['email_verified_at' => 'datetime'];

    public function canAccessFilament(): bool
    {
        $key = "auth.{$this->id}.role";
        $role = session()->get($key);

        if (\in_array(needle: $role, haystack: [Roles::PROVIDER, Roles::ADMIN], strict: true)) {
            return true;
        }

        /** @var \Modules\Auth\Infrastructure\Managers\VerifyUserAccessManager $verify */
        $verify = app(abstract: VerifyUserAccessManagerContract::class);

        if ($verify->provider(user: new Ulid(value: $this->id))) {
            session()->put($key, Roles::PROVIDER);

            return true;
        }

        if ($verify->admin(user: new Ulid(value: $this->id))) {
            session()->put($key, Roles::ADMIN);

            return true;
        }

        return false;
    }
}
