<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Resources\ResidenceResource\RelationManagers;

use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Modules\Residence\Domain\Enums\Media;
use Modules\Admin\Infrastructure\Filament as Admin;
use Filament\Resources\RelationManagers\RelationManager;
use Modules\Admin\Infrastructure\Enums\Libraries\Labels;
use Modules\Admin\Infrastructure\Enums\Libraries\Directories;

final class GalleryRelationManager extends RelationManager
{
    protected static string $relationship = 'gallery';

    protected static ?string $recordTitleAttribute = 'path';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(schema: Admin\Forms\Components\MediaUpload::make(
                type: Media::Gallery,
                directory: Directories::Residence,
                named: true,
                required: true,
            ));
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make(name: 'path')->toggleable()->label(label: Labels::Path->value),
                Tables\Columns\TextColumn::make(name: 'name')->sortable()->searchable()->translateLabel(),
                Admin\Tables\Columns\DateTimeColumn::make(name: 'created_at')->translateLabel(),
                Admin\Tables\Columns\DateTimeColumn::make(name: 'updated_at')->translateLabel(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
