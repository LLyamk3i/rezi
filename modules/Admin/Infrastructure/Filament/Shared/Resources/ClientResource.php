<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Shared\Resources;

use Filament\Tables;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Modules\Admin\Infrastructure\Models\Client;
use Modules\Admin\Infrastructure\Filament\Shared;
use Illuminate\Database\Eloquent\SoftDeletingScope;

final class ClientResource extends Resource
{
    protected static null | string $model = Client::class;

    protected static null | string $navigationIcon = 'heroicon-o-users';

    protected static null | string $navigationLabel = 'clients';

    protected static null | int $navigationSort = 3;

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns(components: Shared\Tables\Columns\UserColumns::make())
            ->filters(filters: [
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions(actions: [
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions(actions: [
                Tables\Actions\BulkActionGroup::make(actions: [
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    /**
     * @return Builder<Client>
     */
    public static function getEloquentQuery(): Builder
    {
        return Client::query()->withoutGlobalScopes(scopes: [
            SoftDeletingScope::class,
        ]);
    }

    /**
     * @return array<string,\Filament\Resources\Pages\PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => ClientResource\Pages\ManageClients::route(path: '/'),
        ];
    }
}
