<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Modules\Residence\Domain\Enums\Media;
use Modules\Residence\Infrastructure\Models\Feature;
use Modules\Admin\Infrastructure\Enums\Libraries\Directories;
use Modules\Admin\Infrastructure\Filament\Forms\Components\MediaUpload;
use Modules\Admin\Infrastructure\Filament\Resources\FeatureResource\Pages;

final class FeatureResource extends Resource
{
    protected static ?string $model = Feature::class;

    protected static ?string $navigationIcon = 'heroicon-o-view-grid-add';

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationLabel = 'points forts';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make(name: 'name')->required()->translateLabel()->columnSpanFull(),
                Forms\Components\Fieldset::make(label: 'icon')
                    ->relationship(relationshipName: 'icon')
                    ->schema(components: MediaUpload::make(
                        type: Media::Icon,
                        directory: Directories::Feature,
                        mimes: ['image/svg+xml', 'image/png'],
                    )),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(columns: [
                Tables\Columns\TextColumn::make(name: 'name')->searchable()->translateLabel(),
                Tables\Columns\TextColumn::make(name: 'created_at')->dateTime()->sortable()->toggleable()->translateLabel(),
                Tables\Columns\TextColumn::make(name: 'updated_at')->dateTime()->sortable()->toggleable()->translateLabel(),
            ])
            ->actions(actions: [
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions(actions: [
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    /**
     * @return array{index:array<string,string>}
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageFeatures::route(path: '/'),
        ];
    }
}
