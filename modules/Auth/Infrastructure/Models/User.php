<?php

declare(strict_types=1);

namespace Modules\Auth\Infrastructure\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Auth\Infrastructure\Database\Factories\UserFactory;

final class User extends Authenticatable
{
    use \Laravel\Sanctum\HasApiTokens;
    use \Illuminate\Notifications\Notifiable;
    use \Illuminate\Database\Eloquent\Concerns\HasUlids;

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

    /**
     * @return BelongsToMany<Role>
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public static function factory(): UserFactory
    {
        return new UserFactory();
    }
}
