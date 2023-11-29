<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Shared\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Modules\Admin\Infrastructure\Filament\Shared;
use Modules\Residence\Infrastructure\Models\Residence;
use Modules\Admin\Infrastructure\Enums\Libraries\Labels;

class ResidenceResource extends Resource
{
    protected static null | string $model = Residence::class;

    protected static null | int $navigationSort = 1;

    protected static null | string $navigationIcon = 'heroicon-o-home-modern';

    /**
     * @throws \InvalidArgumentException
     */
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema(components: [
            Forms\Components\TextInput::make(name: 'name')->required(),
            Forms\Components\TextInput::make(name: 'rent')->required()->numeric()->translateLabel()->prefix(label: 'Franc FCFA'),
            Forms\Components\TextInput::make(name: 'address')->required()->translateLabel(),
            Forms\Components\TextInput::make(name: 'rooms')->required()->numeric()->translateLabel()->minValue(value: 1)->maxValue(value: 8),
            Shared\Resources\ResidenceResource\Fields\TypeField::make(),
            Shared\Resources\ResidenceResource\Fields\FeaturesField::make(),
            Forms\Components\Textarea::make(name: 'description')->columnSpanFull(),
            Shared\Resources\ResidenceResource\Fields\PosterField::make(),
            Shared\Resources\ResidenceResource\Fields\LocationField::make(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns(components: array_filter(array: [
                Tables\Columns\ImageColumn::make(name: 'poster.path')->toggleable()->label(label: Labels::Poster->value),
                Tables\Columns\TextColumn::make(name: 'name')->sortable()->searchable()->translateLabel(),
                Tables\Columns\TextColumn::make(name: 'rent')->money()->searchable()->sortable()->translateLabel()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make(name: 'address')->searchable()->translateLabel(),
                Tables\Columns\TextColumn::make(name: 'description')->searchable()->toggleable(isToggledHiddenByDefault: true),
                Shared\Tables\Columns\VisibilityColumn::make(name: 'visible')->sortable(),
                Shared\Resources\ResidenceResource\Tables\Columns\ProviderColumn::make(),
                Shared\Tables\Columns\DateTimeColumn::make(name: 'created_at')->translateLabel(),
                Shared\Tables\Columns\DateTimeColumn::make(name: 'updated_at')->translateLabel(),
            ]))
            ->filters(filters: [
                //
            ])
            ->actions(actions: array_filter(array: [
                Tables\Actions\EditAction::make(),
                Shared\Resources\ResidenceResource\Tables\Actions\ToggleResidenceVisibilityAction::make(),
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
            Shared\Resources\ResidenceResource\RelationManagers\GalleryRelationManager::class,
        ];
    }

    /**
     * @return array<string,\Filament\Resources\Pages\PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => Shared\Resources\ResidenceResource\Pages\ListResidences::route(path: '/'),
            'create' => Shared\Resources\ResidenceResource\Pages\CreateResidence::route(path: '/create'),
            'edit' => Shared\Resources\ResidenceResource\Pages\EditResidence::route(path: '/{record}/edit'),
        ];
    }
}
