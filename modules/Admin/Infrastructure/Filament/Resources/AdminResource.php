<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Modules\Admin\Infrastructure\Filament as Admin;
use Modules\Admin\Infrastructure\Models\Admin as Model;
use Modules\Admin\Infrastructure\Filament\Resources\AdminResource\Pages;

final class AdminResource extends Resource
{
    protected static ?string $model = Model::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-circle';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form->schema(schema: [
            Forms\Components\TextInput::make(name: 'forename')->required(),
            Forms\Components\TextInput::make(name: 'surname')->required(),
            Forms\Components\TextInput::make(name: 'email')->email()->required(),
            Forms\Components\DateTimePicker::make(name: 'email_verified_at'),
            Forms\Components\TextInput::make(name: 'password')
                ->password()
                ->required()
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(columns: Admin\Tables\Columns\UserColumns::make())
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
     * @return array{index:array<string,string>,create:array<string,string>,edit:array<string,string>}
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdmins::route(path: '/'),
            'create' => Pages\CreateAdmin::route(path: '/create'),
            'edit' => Pages\EditAdmin::route(path: '/{record}/edit'),
        ];
    }
}
