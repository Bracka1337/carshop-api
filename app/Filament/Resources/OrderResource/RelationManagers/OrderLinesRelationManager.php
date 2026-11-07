<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\Models\Product;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrderLinesRelationManager extends RelationManager
{
    protected static string $relationship = 'lines';

    protected static ?string $title = 'Products';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('product_id')
                    ->label('Product')
                    ->relationship('product', 'title')
                    ->getOptionLabelFromRecordUsing(fn (Product $product) => "#{$product->id} {$product->title}")
                    ->searchable(['id', 'title'])
                    ->required(),
                TextInput::make('quantity')->integer()->minValue(1)->required(),
                TextInput::make('unit_price')
                    ->numeric()
                    ->minValue(0)
                    ->helperText('Leave empty to use the current product price.'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product_id')->label('Product ID'),
                TextColumn::make('product.title')->label('Product'),
                TextColumn::make('quantity'),
                TextColumn::make('unit_price')->money('USD'),
                ImageColumn::make('product.images.img_uri')->stacked()->limit(1),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()->label('New Product')->recordTitle('Product'),
            ])
            ->recordActions([
                EditAction::make()->recordTitle('Product'),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
