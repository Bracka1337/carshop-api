<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use App\Models\User;
class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')->relationship('user', 'email')->label('User Email')->searchable()->options(User::all()->pluck('email', 'id')),
                Select::make('status')->options([
                    'Processing' => 'Processing',
                    'Delivering' => 'Delivering',
                    'Delivered' => 'Delivered',
                    'Failed' => 'Failed',
                ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->searchable(),
                TextColumn::make('user.email')->searchable(),
                TextColumn::make('payment_id')->searchable(),
                TextColumn::make('date')->dateTime(),
                TextColumn::make('status')->badge()->color(fn (string $state): string => match ($state) {
                    'Processing' => 'gray',
                    'Delivering' => 'warning',
                    'Delivered' => 'success',
                    'Failed' => 'danger',
                }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
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
