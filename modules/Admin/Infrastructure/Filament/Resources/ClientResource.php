<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Resources;

use Filament\Tables;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Modules\Auth\Infrastructure\Models\User;
use Modules\Admin\Infrastructure\Filament\Resources\ClientResource\Pages;

final class ClientResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'clients';

    protected static ?int $navigationSort = 3;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make(name: 'name')->searchable(),
                Tables\Columns\TextColumn::make(name: 'surname')->searchable(),
                Tables\Columns\TextColumn::make(name: 'email')->searchable(),
                Tables\Columns\TextColumn::make(name: 'email_verified_at')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make(name: 'created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make(name: 'updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    /**
     * @return array{index:array<string,string>}
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageClients::route(path: '/'),
        ];
    }
}
