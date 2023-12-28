<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Authentication\Infrastructure\Models\User;
use Modules\Residence\Infrastructure\Database\Factories\RatingFactory;

final class Rating extends Model
{
    use \Illuminate\Database\Eloquent\Concerns\HasUlids;

    /**
     * @var non-empty-array<string,string>
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:i',
    ];

    /**
     * @var non-empty-array<int,string>
     */
    protected $guarded = ['id', 'updated_at', 'created_at'];

    /**
     * @return BelongsTo<User,Rating>
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(related: User::class, foreignKey: 'user_id');
    }

    public static function factory(): RatingFactory
    {
        return new RatingFactory();
    }
}
