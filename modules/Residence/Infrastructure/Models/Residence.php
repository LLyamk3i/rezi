<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Shared\Infrastructure\Models\Media;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Shared\Domain\Enums\Media as MediaType;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Reservation\Infrastructure\Models\Reservation;
use Modules\Residence\Infrastructure\Database\Factories\ResidenceFactory;

final class Residence extends Model
{
    use \Illuminate\Database\Eloquent\Concerns\HasUlids;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $guarded = ['id', 'updated_at', 'created_at'];

    /**
     * @return HasMany<Reservation>
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(related: Reservation::class);
    }

    /**
     * @return MorphOne<Media>
     */
    public function cover(): MorphOne
    {
        return $this->morphOne(related: Media::class, name: 'fileable')
            ->where('type', MediaType::Poster);
    }

    public static function factory(): ResidenceFactory
    {
        return new ResidenceFactory();
    }
}
