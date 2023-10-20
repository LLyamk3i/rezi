<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Owner\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Modules\Admin\Infrastructure\Filament\Shared;
use Modules\Admin\Infrastructure\Models\Admin as Model;
use Modules\Admin\Infrastructure\Filament\Owner\Resources\AdminResource\Pages;

final class AdminResource extends Resource
{
    protected static ?string $model = Model::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-circle';

    protected static ?int $navigationSort = 5;

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema(components: [
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
            'index' => Pages\ListAdmins::route(path: '/'),
            'create' => Pages\CreateAdmin::route(path: '/create'),
            'edit' => Pages\EditAdmin::route(path: '/{record}/edit'),
        ];
    }
}
