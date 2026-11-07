<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages\EditPayment;
use App\Filament\Resources\PaymentResource\Pages\ListPayments;
use App\Models\Payment;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-credit-card';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('status')->options([
                    'Processing' => 'Processing',
                    'Unpaid' => 'Unpaid',
                    'Refunded' => 'Refunded',
                    'Failed' => 'Failed',
                    'Success' => 'Success',
                ])->default('Default'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->searchable(),
                TextColumn::make('date')->label('Paid On'),
                TextColumn::make('order.id')->label('Order ID'),
                TextColumn::make('status')->label('Payment Status')->badge()->color(fn (string $state): string => match ($state) {
                    'Processing' => 'gray',
                    'Unpaid' => 'warning',
                    'Refunded' => 'warning',
                    'Failed' => 'danger',
                    'Success' => 'success',
                }),
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
            'index' => ListPayments::route('/'),
            'edit' => EditPayment::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
