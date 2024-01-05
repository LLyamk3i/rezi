<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Shared\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Modules\Residence\Domain\Enums\Media;
use Modules\Admin\Infrastructure\Filament\Shared;
use Modules\Residence\Infrastructure\Models\Feature;
use Modules\Admin\Infrastructure\Enums\Libraries\Directories;

final class FeatureResource extends Resource
{
    protected static null | string $model = Feature::class;

    protected static null | string $navigationIcon = 'heroicon-o-squares-plus';

    protected static null | int $navigationSort = 6;

    protected static null | string $navigationLabel = 'points forts';

    /**
     * @throws \InvalidArgumentException
     */
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make(name: 'name')->required()->translateLabel()->columnSpanFull(),
                Forms\Components\Fieldset::make(label: 'icon')
                    ->relationship(name: 'icon')
                    ->schema(components: Shared\Forms\Components\MediaUpload::make(
                        type: Media::Icon,
                        directory: Directories::Feature,
                        mimes: ['image/svg+xml', 'image/png'],
                    )),
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
                Tables\Actions\BulkActionGroup::make(actions: [
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * @return array<string,\Filament\Resources\Pages\PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => FeatureResource\Pages\ManageFeatures::route(path: '/'),
        ];
    }
}
