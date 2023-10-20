<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Shared\Resources;

use Filament\Tables;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Modules\Admin\Infrastructure\Filament\Shared;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Modules\Authentication\Infrastructure\Models\User;

final class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'utilisateurs';

    protected static ?int $navigationSort = 3;

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
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions(actions: [
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ]);
    }

    /**
     * @return Builder<User>
     */
    public static function getEloquentQuery(): Builder
    {
        return User::query()->clients()->withoutGlobalScopes(scopes: [
            SoftDeletingScope::class,
        ]);
    }

    /**
     * @return array{index:\Filament\Resources\Pages\PageRegistration}
     */
    public static function getPages(): array
    {
        return [
            'index' => Shared\Resources\UserResource\Pages\ManageUsers::route(path: '/'),
        ];
    }
}
