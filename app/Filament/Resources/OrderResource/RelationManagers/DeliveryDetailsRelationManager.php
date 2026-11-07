<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\Enums\DeliveryMethod;
use App\Enums\PaymentMethod;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DeliveryDetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'delivery_details';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('f_name')->placeholder('-')->label('First name'),
                TextInput::make('m_name')->placeholder('-')->label('Middle name'),
                TextInput::make('l_name')->placeholder('-')->label('Last name'),
                TextInput::make('addr_line_1')->placeholder('-')->label('Address line 1'),
                TextInput::make('addr_line_2')->placeholder('-')->label('Address line 2'),
                TextInput::make('country')->placeholder('-'),
                TextInput::make('company_email')->placeholder('-'),
                TextInput::make('company_name')->placeholder('-'),
                TextInput::make('company_reg_nr')->placeholder('-'),
                Select::make('payment_method')->placeholder('-')->options(PaymentMethod::class),
                Select::make('delivery_method')->placeholder('-')->options(DeliveryMethod::class),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitle('Delivery Details')
            ->columns([
                TextColumn::make('id')->label('ID')->searchable(),
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
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
