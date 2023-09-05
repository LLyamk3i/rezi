<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Modules\Residence\Infrastructure\Models\Type;
use Modules\Admin\Infrastructure\Filament\Resources\TypeResource\Pages;

final class TypeResource extends Resource
{
    protected static ?string $model = Type::class;

    protected static ?int $navigationSort = 7;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make(name: 'name')->required()->translateLabel()->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make(name: 'name')->searchable()->translateLabel(),
                Tables\Columns\TextColumn::make(name: 'created_at')->dateTime()->sortable()->toggleable()->translateLabel(),
                Tables\Columns\TextColumn::make(name: 'updated_at')->dateTime()->sortable()->toggleable()->translateLabel(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ManageTypes::route(path: '/'),
        ];
    }
}
