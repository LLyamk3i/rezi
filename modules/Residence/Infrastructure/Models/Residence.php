<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Infrastructure\Models\User;
use Modules\Shared\Infrastructure\Models\Media;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Residence\Domain\Enums\Media as MediaType;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Reservation\Infrastructure\Models\Reservation;
use Modules\Residence\Infrastructure\Models\Attributes\VisibleAttribute;
use Modules\Residence\Infrastructure\Database\Factories\ResidenceFactory;

final class Residence extends Model
{
    use \Illuminate\Database\Eloquent\Concerns\HasUlids;

    protected $casts = [
        'visible' => 'boolean',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $guarded = ['id', 'updated_at', 'created_at'];

    /*
    |--------------------------------------------------------------------------
    | Attributes
    |--------------------------------------------------------------------------
    */
    public function visible(): VisibleAttribute
    {
        return new VisibleAttribute(residence: $this);
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    /**
     * @return HasMany<Reservation>
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(related: Reservation::class);
    }

    /**
     * @return BelongsTo<User,Residence>
     */
    public function provider(): BelongsTo
    {
        return $this->belongsTo(related: User::class, foreignKey: 'user_id');
    }

    /**
     * @return MorphOne<Media>
     */
    public function poster(): MorphOne
    {
        return $this->morphOne(related: Media::class, name: 'fileable')->where('type', MediaType::Poster);
    }

    /**
     * @return MorphMany<Media>
     */
    public function gallery(): MorphMany
    {
        return $this->morphMany(related: Media::class, name: 'fileable')->where('type', MediaType::Gallery);
    }

    /**
     * @return HasOne<Type>
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(related: Type::class);
    }

    /**
     * @return BelongsToMany<Feature,Residence>
     */
    public function features(): BelongsToMany
    {
        return $this->belongsToMany(related: Feature::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Factory
    |--------------------------------------------------------------------------
    */
    public static function factory(): ResidenceFactory
    {
        return new ResidenceFactory();
    }
}
