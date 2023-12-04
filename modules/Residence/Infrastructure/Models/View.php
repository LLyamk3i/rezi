<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

final class View extends Model
{
    use \Illuminate\Database\Eloquent\Concerns\HasUlids;

    protected $guarded = ['id', 'updated_at', 'created_at'];
}
