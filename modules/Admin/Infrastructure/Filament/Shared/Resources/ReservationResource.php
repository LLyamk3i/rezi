<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Shared\Resources;

use Filament\Tables;
use Filament\Resources\Resource;
use Modules\Admin\Infrastructure\Filament\Shared;
use Modules\Reservation\Infrastructure\Models\Reservation;

final class ReservationResource extends Resource
{
    protected static null | string $model = Reservation::class;

    protected static null | string $navigationIcon = 'heroicon-o-calendar';

    protected static null | int $navigationSort = 2;

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns(components: [
                Tables\Columns\ImageColumn::make(name: 'residence.poster.path')->searchable(),
                Tables\Columns\TextColumn::make(name: 'checkin_at')->dateTime()->sortable()->translateLabel(),
                Tables\Columns\TextColumn::make(name: 'checkout_at')->dateTime()->sortable()->translateLabel(),
                Tables\Columns\TextColumn::make(name: 'client.name')->searchable(),
                Tables\Columns\TextColumn::make(name: 'status')->searchable(),
                Tables\Columns\TextColumn::make(name: 'cost')->money()->sortable()->translateLabel(),
                Shared\Tables\Columns\DateTimeColumn::make(name: 'created_at')->translateLabel(),
                Shared\Tables\Columns\DateTimeColumn::make(name: 'updated_at')->translateLabel(),
            ])
            ->filters(filters: []);
    }

    /**
     * @return array<string,\Filament\Resources\Pages\PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => Shared\Resources\ReservationResource\Pages\ManageReservations::route(path: '/'),
        ];
    }
}
