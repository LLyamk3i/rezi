<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Concerns\Model;

use Modules\Auth\Infrastructure\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait UserConcern
{
    use \Illuminate\Database\Eloquent\Concerns\HasUlids;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    public function getTable(): string
    {
        return 'users';
    }

    /**
     * @return array<int,string>
     */
    public function getGuarded(): array
    {
        return ['id', 'email_verified_at', 'created_at', 'updated_at'];
    }

    /**
     * @return array<int,string>
     */
    public function getHidden(): array
    {
        return ['password', 'remember_token'];
    }

    /**
     * @return array<string,string>
     */
    public function getCasts(): array
    {
        return ['email_verified_at' => 'datetime'];
    }

    /**
     * @return BelongsToMany<Role>
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            related: Role::class,
            table: 'role_user',
            foreignPivotKey: 'user_id',
            relatedPivotKey: 'role_id'
        );
    }
}
