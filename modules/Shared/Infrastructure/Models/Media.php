<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Shared\Infrastructure\Database\Factories\MediaFactory;

final class Media extends Model
{
    use \Illuminate\Database\Eloquent\Concerns\HasUlids;

    /**
     * @var array<int,string>
     */
    protected $guarded = ['id', 'fileable_type', 'fileable_id', 'created_at', 'updated_at'];

    /**
     * @return MorphTo<Model,Media>
     */
    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }

    public static function factory(): MediaFactory
    {
        return new MediaFactory();
    }
}
