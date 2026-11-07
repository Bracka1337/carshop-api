<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ImageResource\Pages\CreateImage;
use App\Filament\Resources\ImageResource\Pages\EditImage;
use App\Filament\Resources\ImageResource\Pages\ListImages;
use App\Models\Image;
use App\Models\Product;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ImageResource extends Resource
{
    protected static ?string $model = Image::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-photo';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('img_uri')->label('Image')->disk('public')->directory('images')->endsWith([
                    '.webp',
                ])->validationMessages([
                    'endsWith' => 'Image should be in .webp format',
                ]),
                Select::make('product_id')->label('Product')->options(Product::pluck('id', 'id'))->searchable()->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                ImageColumn::make('img_uri')->label('Image'),
                TextColumn::make('product_id'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
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
            'index' => ListImages::route('/'),
            'create' => CreateImage::route('/create'),
            'edit' => EditImage::route('/{record}/edit'),
        ];
    }
}
