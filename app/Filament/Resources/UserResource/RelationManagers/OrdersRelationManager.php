<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
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

    public function form(Form $form): Form
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
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('user_id')
            ->columns([
                TextColumn::make('id')->searchable(),
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
