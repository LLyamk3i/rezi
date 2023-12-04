<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Authentication\Infrastructure\Models\User;

final class Favorite extends Model
{
    use \Illuminate\Database\Eloquent\Concerns\HasUlids;

    protected $fillable = ['user_id', 'residence_id'];

    /**
     * @return BelongsTo<Residence,Favorite>
     */
    public function residence(): BelongsTo
    {
        return $this->belongsTo(related: Residence::class);
    }

    /**
     * @return BelongsTo<User,Favorite>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(related: User::class);
    }
}
