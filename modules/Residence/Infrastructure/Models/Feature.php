<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Shared\Infrastructure\Models\Media;
use Modules\Residence\Domain\Enums\Media as Type;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Residence\Infrastructure\Database\Factories\FeatureFactory;

final class Feature extends Model
{
    use \Illuminate\Database\Eloquent\Concerns\HasUlids;

    protected $guarded = ['id', 'updated_at', 'created_at'];

    /**
     * @return MorphOne<Media>
     */
    public function icon(): MorphOne
    {
        return $this->morphOne(related: Media::class, name: 'fileable')->where('type', Type::Icon);
    }

    /**
     * @return BelongsTo<Residence,Feature>
     */
    public function residence(): BelongsTo
    {
        return $this->belongsTo(related: Residence::class);
    }

    public static function factory(): FeatureFactory
    {
        return FeatureFactory::new();
    }
}
