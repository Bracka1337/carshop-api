<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages\CreateOrder;
use App\Filament\Resources\OrderResource\Pages\EditOrder;
use App\Filament\Resources\OrderResource\Pages\ListOrders;
use App\Filament\Resources\OrderResource\RelationManagers\DeliveryDetailsRelationManager;
use App\Filament\Resources\OrderResource\RelationManagers\ProductQuantitiesRelationManager;
use App\Models\Order;
use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')->relationship('user', 'email')->label('User Email')->searchable()->options(User::pluck('email', 'id')),
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
                    'Success' => 'Success',
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->searchable(),
                TextColumn::make('user.email')->searchable(),
                TextColumn::make('date')->dateTime(),
                TextColumn::make('status')->badge()->color(fn (string $state): string => match ($state) {
                    'Processing' => 'gray',
                    'Delivering' => 'warning',
                    'Delivered' => 'success',
                    'Failed' => 'danger',
                    default => 'gray',
                }),
                TextColumn::make('payment_id')->searchable(),
                TextColumn::make('payment.date')->label('Paid On')->dateTime(),
                TextColumn::make('payment.status')->label('Payment Status')->badge()->color(fn (string $state): string => match ($state) {
                    'Processing' => 'gray',
                    'Unpaid' => 'warning',
                    'Refunded' => 'warning',
                    'Failed' => 'danger',
                    'Success' => 'success',
                    default => 'gray',
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
            DeliveryDetailsRelationManager::class,
            ProductQuantitiesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrders::route('/'),
            'create' => CreateOrder::route('/create'),
            'edit' => EditOrder::route('/{record}/edit'),
        ];
    }
}
