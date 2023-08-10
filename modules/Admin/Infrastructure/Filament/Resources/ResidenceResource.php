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
use Modules\Admin\Infrastructure\Filament\Resources\ResidenceResource as Container;

class ResidenceResource extends Resource
{
    protected static ?string $model = Residence::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make(name: 'name')->required()->label(label: 'nom'),
            Forms\Components\TextInput::make(name: 'rent')->required()->numeric()->prefix(label: 'Franc FCFA')->label(label: 'loyer'),
            Forms\Components\TextInput::make(name: 'address')->required()->columnSpan(span: 'full')->label(label: 'adresse'),
            Forms\Components\Textarea::make(name: 'description')->required()->columnSpan(span: 'full'),
            Admin\Forms\Components\Map::make(name: 'location')->required()->columnSpan(span: 'full')->label(label: 'localization'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(columns: [
                Tables\Columns\TextColumn::make(name: 'name')->sortable()->searchable()->label(label: 'nom'),
                Tables\Columns\TextColumn::make(name: 'rent')->money()->searchable()->sortable()->label(label: 'loyer'),
                Tables\Columns\TextColumn::make(name: 'address')->searchable()->label(label: 'adresse'),
                Tables\Columns\TextColumn::make(name: 'description')->searchable()->toggleable(isToggledHiddenByDefault: true),
                Admin\Tables\Columns\VisibilityColumn::make(name: 'visible')->sortable(),
                Container\Tables\Columns\ProviderColumn::make(),
                Admin\Tables\Columns\DateTimeColumn::make(name: 'created_at')->label(label: 'date de création'),
                Admin\Tables\Columns\DateTimeColumn::make(name: 'updated_at')->label(label: 'date de modification'),
            ])
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
