<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Resources;

use Filament\Tables;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Modules\Admin\Infrastructure\Filament as Admin;
use Modules\Reservation\Infrastructure\Models\Reservation;
use Modules\Admin\Infrastructure\Filament\Resources\ReservationResource\Pages;

final class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?int $navigationSort = 2;

    public static function table(Table $table): Table
    {
        return $table
            ->columns(columns: [
                Tables\Columns\ImageColumn::make(name: 'residence.poster.path')->searchable(),
                Tables\Columns\TextColumn::make(name: 'checkin_at')->dateTime()->sortable()->translateLabel(),
                Tables\Columns\TextColumn::make(name: 'checkout_at')->dateTime()->sortable()->translateLabel(),
                Tables\Columns\TextColumn::make(name: 'client.name')->searchable(),
                Tables\Columns\TextColumn::make(name: 'status')->searchable(),
                Tables\Columns\TextColumn::make(name: 'cost')->money()->sortable()->translateLabel(),
                Admin\Tables\Columns\DateTimeColumn::make(name: 'created_at')->translateLabel(),
                Admin\Tables\Columns\DateTimeColumn::make(name: 'updated_at')->translateLabel(),
            ])
            ->filters(filters: []);
    }

    /**
     * @return array{index:array<string,string>}
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageReservations::route(path: '/'),
        ];
    }
}
