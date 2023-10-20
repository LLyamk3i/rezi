<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Shared\Resources;

use Filament\Tables;
use Filament\Resources\Resource;
use Modules\Admin\Infrastructure\Filament\Shared;
use Modules\Admin\Infrastructure\Models\Provider;

final class ProviderResource extends Resource
{
    protected static ?string $model = Provider::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationLabel = 'propriétaires';

    protected static ?int $navigationSort = 4;

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
     * @return array<string,\Filament\Resources\Pages\PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => Shared\Resources\ProviderResource\Pages\ManageProviders::route(path: '/'),
        ];
    }
}
