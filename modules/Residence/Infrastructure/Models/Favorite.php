<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Authentication\Infrastructure\Models\User;
use Modules\Residence\Infrastructure\Database\Factories\FavoriteFactory;

final class Favorite extends Model
{
    use \Illuminate\Database\Eloquent\Concerns\HasUlids;

    protected $guarded = ['id', 'updated_at', 'created_at'];

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

    public static function factory(): FavoriteFactory
    {
        return FavoriteFactory::new();
    }
}
