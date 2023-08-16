<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Modules\Admin\Infrastructure\Filament as Admin;
use Modules\Residence\Infrastructure\Models\Residence;
use Modules\Admin\Infrastructure\Enums\Libraries\Labels;
use Modules\Admin\Infrastructure\Filament\Resources\ResidenceResource as Container;

final class ResidenceResource extends Resource
{
    protected static ?string $model = Residence::class;

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-office-building';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make(name: 'name')->required()->translateLabel(),
            Forms\Components\TextInput::make(name: 'rent')->required()->numeric()->translateLabel()->prefix(label: 'Franc FCFA'),
            Forms\Components\TextInput::make(name: 'address')->required()->translateLabel(),
            Forms\Components\TextInput::make(name: 'rooms')->required()->numeric()->translateLabel()->minValue(value: 1)->maxValue(value: 8),
            Container\Fields\TypeField::make(),
            Container\Fields\FeaturesField::make(),
            Forms\Components\Textarea::make(name: 'description')->columnSpan(span: 'full'),
            Container\Fields\PosterField::make(),
            Container\Fields\LocationField::make(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(columns: array_filter(array: [
                Tables\Columns\ImageColumn::make(name: 'poster.path')->toggleable()->label(label: Labels::Poster->value),
                Tables\Columns\TextColumn::make(name: 'name')->sortable()->searchable()->translateLabel(),
                Tables\Columns\TextColumn::make(name: 'rent')->money()->searchable()->sortable()->translateLabel()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make(name: 'address')->searchable()->translateLabel(),
                Tables\Columns\TextColumn::make(name: 'description')->searchable()->toggleable(isToggledHiddenByDefault: true),
                Admin\Tables\Columns\VisibilityColumn::make(name: 'visible')->sortable(),
                Container\Tables\Columns\ProviderColumn::make(),
                Admin\Tables\Columns\DateTimeColumn::make(name: 'created_at')->translateLabel(),
                Admin\Tables\Columns\DateTimeColumn::make(name: 'updated_at')->translateLabel(),
            ]))
            ->filters(filters: [
                //
            ])
            ->actions(actions: array_filter(array: [
                Tables\Actions\EditAction::make(),
                Container\Tables\Actions\ToggleResidenceVisibilityAction::make(),
            ]))
            ->bulkActions(actions: [
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    /**
     * @return array<int,class-string<\Filament\Resources\RelationManagers\RelationManager>>
     */
    public static function getRelations(): array
    {
        return [
            Container\RelationManagers\GalleryRelationManager::class,
        ];
    }

    /**
     * @return array{index:array<string,string>,create:array<string,string>,edit:array<string,string>}
     */
    public static function getPages(): array
    {
        return [
            'index' => Container\Pages\ListResidences::route(path: '/'),
            'create' => Container\Pages\CreateResidence::route(path: '/create'),
            'edit' => Container\Pages\EditResidence::route(path: '/{record}/edit'),
        ];
    }
}
