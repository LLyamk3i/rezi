<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Models;

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

        if (\is_string(value: $role) && \in_array(needle: $role, haystack: ['provider', 'admin'], strict: true)) {
            return true;
        }

        /** @var \Modules\Auth\Infrastructure\Managers\VerifyUserAccessManager $verify */
        $verify = app(abstract: VerifyUserAccessManagerContract::class);

        if ($verify->provider(user: new Ulid(value: $this->id))) {
            session()->put($key, 'provider');

            return true;
        }

        if ($verify->admin(user: new Ulid(value: $this->id))) {
            session()->put($key, 'admin');

            return true;
        }

        return false;
    }
}
