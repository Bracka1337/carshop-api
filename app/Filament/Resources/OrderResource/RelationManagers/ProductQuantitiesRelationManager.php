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

class ProductQuantitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'productQuantities';

    protected static ?string $title = 'Products';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('product_id')->options(Product::pluck('id'))->searchable(),
                TextInput::make('quantity'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product_id'),
                TextColumn::make('quantity'),
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
