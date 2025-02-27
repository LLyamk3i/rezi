<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Shared\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Modules\Residence\Infrastructure\Models\Type;

final class TypeResource extends Resource
{
    protected static null | string $model = Type::class;

    protected static null | int $navigationSort = 7;

    protected static null | string $navigationIcon = 'heroicon-o-sparkles';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema(components: [
            Forms\Components\TextInput::make(name: 'name')->required()->translateLabel()->columnSpanFull(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns(components: [
                Tables\Columns\TextColumn::make(name: 'name')->searchable()->translateLabel(),
                Tables\Columns\TextColumn::make(name: 'created_at')->dateTime()->sortable()->toggleable()->translateLabel(),
                Tables\Columns\TextColumn::make(name: 'updated_at')->dateTime()->sortable()->toggleable()->translateLabel(),
            ])
            ->actions(actions: [
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions(actions: [
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    /**
     * @return array{index:\Filament\Resources\Pages\PageRegistration}
     */
    public static function getPages(): array
    {
        return [
            'index' => TypeResource\Pages\ManageTypes::route(path: '/'),
        ];
    }
}
