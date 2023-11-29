<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Shared\Resources\ResidenceResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Modules\Residence\Domain\Enums\Media;
use Modules\Admin\Infrastructure\Filament\Shared;
use Filament\Resources\RelationManagers\RelationManager;
use Modules\Admin\Infrastructure\Enums\Libraries\Labels;
use Modules\Admin\Infrastructure\Enums\Libraries\Directories;

final class GalleryRelationManager extends RelationManager
{
    protected static string $relationship = 'gallery';

    protected static null | string $recordTitleAttribute = 'path';

    /**
     * @throws \InvalidArgumentException
     */
    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema(components: Shared\Forms\Components\MediaUpload::make(
                type: Media::Gallery,
                directory: Directories::Residence,
                named: true,
                required: true,
            ));
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns(components: [
                Tables\Columns\ImageColumn::make(name: 'path')->toggleable()->label(label: Labels::Path->value),
                Tables\Columns\TextColumn::make(name: 'name')->sortable()->searchable()->translateLabel(),
                Shared\Tables\Columns\DateTimeColumn::make(name: 'created_at')->translateLabel(),
                Shared\Tables\Columns\DateTimeColumn::make(name: 'updated_at')->translateLabel(),
            ])
            ->headerActions(actions: [
                Tables\Actions\CreateAction::make(),
            ])
            ->actions(actions: [
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions(actions: [
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
