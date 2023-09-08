<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class Permission extends Model
{
    use \Illuminate\Database\Eloquent\Concerns\HasUlids;

    /**
     * @var array<int,string>
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @return BelongsToMany<Role>
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(related: Role::class);
    }
}
