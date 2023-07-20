<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Modules\Residence\Infrastructure\Models\Residence;
use Modules\Admin\Infrastructure\Filament\Forms as AdminForms;
use Modules\Admin\Infrastructure\Filament\Resources\ResidenceResource\Pages;

class ResidenceResource extends Resource
{
    protected static ?string $model = Residence::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make(name: 'name')->required(),
            Forms\Components\TextInput::make(name: 'rent')->required()->numeric(),
            Forms\Components\TextInput::make(name: 'address')->required()->columnSpan(span: 'full'),
            Forms\Components\Textarea::make(name: 'description')->required()->columnSpan(span: 'full'),
            AdminForms\Components\Map::make(name: 'location')->required()->columnSpan('full'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make(name: 'name'),
                Tables\Columns\TextColumn::make(name: 'rent'),
                Tables\Columns\TextColumn::make(name: 'address'),
                Tables\Columns\TextColumn::make(name: 'description'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListResidences::route('/'),
            'create' => Pages\CreateResidence::route('/create'),
            'edit' => Pages\EditResidence::route('/{record}/edit'),
        ];
    }
}
