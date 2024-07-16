<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeliveryDetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'delivery_details';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('f_name')->placeholder('-')->label('First name'),
                TextInput::make('m_name')->placeholder('-')->label('Middle name'),
                TextInput::make('l_name')->placeholder('-')->label('Last name'),
                TextInput::make('addr_line_1')->placeholder('-')->label('Address line 1'),
                TextInput::make('addr_line_2')->placeholder('-')->label('Address line 2'),
                TextInput::make('country')->placeholder('-'),
                TextInput::make('company_email')->placeholder('-'),
                TextInput::make('company_name')->placeholder('-'),
                TextInput::make('company_reg_nr')->placeholder('-'),
                Select::make('payment_method')->placeholder('-')->options(['Credit Card' => 'Credit Card', 'Pay on delivery' => 'Pay on delivery']),
                Select::make('delivery_method')->placeholder('-')->options(['DPD' => 'DPD', 'Venipak'=> 'Venipak']),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('f_name')->placeholder('-')->label('First name'),
                TextColumn::make('m_name')->placeholder('-')->label('Middle name'),
                TextColumn::make('l_name')->placeholder('-')->label('Last name'),
                TextColumn::make('addr_line_1')->placeholder('-')->label('Address line 1'),
                TextColumn::make('addr_line_2')->placeholder('-')->label('Address line 2'),
                TextColumn::make('country')->placeholder('-'),
                TextColumn::make('company_email')->placeholder('-'),
                TextColumn::make('company_name')->placeholder('-'),
                TextColumn::make('company_reg_nr')->placeholder('-'),
                TextColumn::make('payment_method')->placeholder('-'),
                TextColumn::make('delivery_method')->placeholder('-'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
