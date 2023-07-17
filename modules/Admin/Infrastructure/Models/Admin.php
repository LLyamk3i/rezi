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
        /** @var VerifyUserAccessManagerContract $verify */
        $verify = app(abstract: VerifyUserAccessManagerContract::class);

        return $verify->admin(user: new Ulid(value: $this->id));
    }
}
