<?php

declare(strict_types=1);

namespace Modules\Auth\Infrastructure\Models;

use Modules\Auth\Domain\Enums\Roles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Auth\Infrastructure\Database\Factories\RoleFactory;

final class Role extends Model
{
    use \Illuminate\Database\Eloquent\Concerns\HasUlids;
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    /**
     * @var array<int,string>
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var array<string,string>
     */
    protected $casts = [
        'name' => Roles::class,
    ];

    /**
     * @return BelongsToMany<Permission>
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(related: Permission::class);
    }

    /**
     * @return BelongsToMany<User>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(related: User::class);
    }

    public static function factory(): RoleFactory
    {
        return new RoleFactory;
    }
}
