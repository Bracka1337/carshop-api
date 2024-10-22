<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use App\Models\Brand;
use Filament\Forms;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->required(),
                MarkdownEditor::make('description')->columnSpanFull()->required(),
                Select::make('diameter')->options(['13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20', '21' => '21', '22' => '22', ])->searchable()->required(),
                Select::make('width')->options(['4.00' => '4.00', '4.50' => '4.50', '5.00' => '5.00', '5.50' => '5.50', '6.00' => '6.00', '6.50' => '6.50', '7.00' => '7.00', '7.25' => '7.25', '7.50' => '7.50', '8.00' => '8.00', '8.25' => '8.25', '8.50' => '8.50', '9.00' => '9.00', '9.50' => '9.50', '10.00' => '10.00', '10.50' => '10.50', '11.00' => '11.00', '11.50' => '11.50', '12.00' => '12.00'])->searchable()->required(),
                Select::make('et')->options(['-44' => '-44', '-35' => '-35', '-32' => '-32', '-30' => '-30', '-20' => '-20', '-15' => '-15', '-13' => '-13', '-12' => '-12', '-10' => '-10', '-1' => '-1', '0' => '0', '5' => '5', '8' => '8', '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '18' => '18', '19' => '19', '20' => '20', '21' => '21', '22' => '22', '23' => '23', '23.5' => '23.5', '24' => '24', '25' => '25', '26' => '26', '27' => '27', '28' => '28', '29' => '29', '30' => '30', '31' => '31', '31.5' => '31.5', '32' => '32', '33' => '33', '34' => '34', '34.5' => '34.5', '35' => '35', '35.5' => '35.5', '36' => '36', '36.5' => '36.5', '37' => '37', '37.5' => '37.5', '38' => '38', '38.5' => '38.5', '39' => '39', '39.5' => '39.5', '40' => '40', '40.5' => '40.5', '41' => '41', '41.5' => '41.5', '42' => '42', '42.5' => '42.5', '43' => '43', '43.5' => '43.5', '44' => '44', '44.5' => '44.5', '45' => '45', '46' => '46', '47' => '47', '47.5' => '47.5', '48' => '48', '48.5' => '48.5', '49' => '49', '49.5' => '49.5', '50' => '50', '50.5' => '50.5', '51' => '51', '52' => '52', '52.5' => '52.5', '53' => '53', '53.5' => '53.5', '54' => '54', '54.5' => '54.5', '55' => '55', '55.5' => '55.5', '56' => '56', '56.4' => '56.4', '57' => '57', '58' => '58', '59' => '59', '60' => '60', '61' => '61', '62' => '62', '62.6' => '62.6', '63' => '63', '64' => '64', '65' => '65', '66' => '66', '67' => '67'])->searchable()->required(),
                Select::make('cb')->options(['54.0' => '54.0', '54.1' => '54.1', '55.1' => '55.1', '56.0' => '56.0', '56.1' => '56.1', '56.5' => '56.5', '56.6' => '56.6', '57.0' => '57.0', '57.1' => '57.1', '57.6' => '57.6', '58.0' => '58.0', '58.1' => '58.1', '60.0' => '60.0', '60.1' => '60.1', '61.1' => '61.1', '63.0' => '63.0', '63.1' => '63.1', '63.3' => '63.3', '63.4' => '63.4', '64.0' => '64.0', '64.1' => '64.1', '64.2' => '64.2', '65.0' => '65.0', '65.06' => '65.06', '65.1' => '65.1', '66.0' => '66.0', '66.1' => '66.1', '66.4' => '66.4', '66.45' => '66.45', '66.5' => '66.5', '66.505' => '66.505', '66.55' => '66.55', '66.6' => '66.6', '66.7' => '66.7', '67.0' => '67.0', '67.1' => '67.1', '67.2' => '67.2', '68.0' => '68.0', '68.1' => '68.1', '69.1' => '69.1', '70.0' => '70.0', '70.1' => '70.1', '70.2' => '70.2', '70.3' => '70.3', '70.5' => '70.5', '70.6' => '70.6', '70.7' => '70.7', '71.0' => '71.0', '71.1' => '71.1', '71.5' => '71.5', '71.6' => '71.6', '72.0' => '72.0', '72.1' => '72.1', '72.3' => '72.3', '72.5' => '72.5', '72.6' => '72.6', '73.0' => '73.0', '73.1' => '73.1', '74.0' => '74.0', '74.1' => '74.1', '74.1' => '74.1', '75.0' => '75.0', '75.1' => '75.1', '76.0' => '76.0', '76.1' => '76.1', '76.9' => '76.9', '78.1' => '78.1', '79.0' => '79.0', '79.1' => '79.1', '82.0' => '82.0', '82.1' => '82.1', '84.0' => '84.0', '84.1' => '84.1', '89.1' => '89.1', '92.1' => '92.1', '92.4' => '92.4', '93.0' => '93.0', '93.1' => '93.1', '95.5' => '95.5', '100.0' => '100.0', '100.1' => '100.1', '106.0' => '106.0', '106.1' => '106.1', '108.1' => '108.1', '108.3' => '108.3', '110.0' => '110.0', '110.1' => '110.1', '114.0' => '114.0', '130.1' => '130.1', '161.1' => '161.1', ])->searchable()->required(),
                Select::make('bolt')->options(['3' => '3', '4' => '4', '5' => '5', '6' => '6'])->required(),
                Select::make('bolt_diameter')->options(['98.00' => '98.00', '100.00' => '100.00', '105.00' => '105.00', '108.00' => '108.00', '110.00' => '110.00', '112.00' => '112.00', '114.30' => '114.30', '115.00' => '115.00', '118.00' => '118.00', '120.00' => '120.00', '125.00' => '125.00', '127.00' => '127.00', '130.00' => '130.00', '135.00' => '135.00', '139.00' => '139.00', '139.70' => '139.70', '140.00' => '140.00', '150.00' => '150.00', '160.00' => '160.00', '165.00' => '165.00', '170.00' => '170.00', '180.00' => '180.00', '200.00' => '200.00', '205.00' => '205.00'])->searchable()->required(),
                Select::make('type')->options(['Alloy' => 'Alloy', 'Steel' => 'Steel'])->required(),
                TextInput::make('price')->minValue(0)->maxValue(10000)->required(),
                Select::make('brand_id')->relationship('Brand', 'title')->options(Brand::all()->pluck('title', 'id'))->required()->searchable(),
            ])->Columns(3);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->searchable(),
                TextColumn::make('title')->searchable()->limit(16),
                TextColumn::make('description')->limit(16),
                TextColumn::make('diameter'),
                TextColumn::make('width'),
                TextColumn::make('et'),
                TextColumn::make('cb'),
                TextColumn::make('bolt'),
                TextColumn::make('bolt_diameter'),
                TextColumn::make('type'),
                TextColumn::make('price')->searchable(),
                TextColumn::make('brand.title')->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ImagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
