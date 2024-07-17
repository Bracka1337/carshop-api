<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use PhpParser\Node\Stmt\Label;

class ProductQuantitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'productQuantities';
    protected static ?string $title = 'Products';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                
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
                Tables\Actions\CreateAction::make()->label('New Product')->recordTitle('Product'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->recordTitle('Product'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
