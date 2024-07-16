<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Filament\Resources\OrderResource\RelationManagers\DeliveryDetailsRelationManager;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use App\Models\User;
class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')->relationship('user', 'email')->label('User Email')->searchable()->options(User::all()->pluck('email', 'id')),
                Select::make('status')->options([
                    'Processing' => 'Processing',
                    'Delivering' => 'Delivering',
                    'Delivered' => 'Delivered',
                    'Failed' => 'Failed',
                ]),
                Select::make('payment.status')->label('Payment Status')->options([
                    'Processing' => 'Processing',
                    'Unpaid' => 'Unpaid',
                    'Refunded' => 'Refunded',
                    'Failed' => 'Failed',
                    'Success'=> 'Success',
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->searchable(),
                TextColumn::make('user.email')->searchable(),
                TextColumn::make('date')->dateTime(),
                TextColumn::make('status')->badge()->color(fn (string $state): string => match ($state) {
                    'Processing' => 'gray',
                    'Delivering' => 'warning',
                    'Delivered' => 'success',
                    'Failed' => 'danger',
                }),
                TextColumn::make('payment_id')->searchable(),
                TextColumn::make('payment.date')->label('Paid On')->dateTime(),
                TextColumn::make('payment.status')->label('Payment Status')->badge()->color(fn (string $state): string => match ($state) {
                    'Processing' => 'gray',
                    'Unpaid' => 'warning',
                    'Refunded' => 'warning',
                    'Failed' => 'danger',
                    'Success'=> 'success',
                }),
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
            DeliveryDetailsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
