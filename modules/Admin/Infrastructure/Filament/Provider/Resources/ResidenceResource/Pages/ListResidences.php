<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Provider\Resources\ResidenceResource\Pages;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Modules\Residence\Infrastructure\Models\Residence;
use Modules\Admin\Infrastructure\Filament\Shared\Resources\ResidenceResource\Pages\ListResidences as ParentResidences;

final class ListResidences extends ParentResidences
{
    /**
     * @return Builder<Residence>
     *
     * @throws \RuntimeException
     */
    protected function getTableQuery(): Builder
    {
        return Residence::query()->where('user_id', Auth::id());
    }
}
