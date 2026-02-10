<?php

namespace App\Filament\Resources\DealerResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class SpecialPricingRelationManager extends RelationManager
{
    protected static string $relationship = 'specialPricing';

    protected static ?string $title = 'Special Pricing';

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name_en')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\TextInput::make('special_price')
                    ->label('Dealer Price (₹)')
                    ->numeric()
                    ->required()
                    ->prefix('₹'),

                Forms\Components\TextInput::make('min_quantity')
                    ->label('Minimum Quantity')
                    ->numeric()
                    ->default(1)
                    ->minValue(1),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name_en')
                    ->label('Product')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('product.price')
                    ->label('Regular Price')
                    ->money('INR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('special_price')
                    ->label('Dealer Price')
                    ->money('INR')
                    ->sortable()
                    ->color('success'),

                Tables\Columns\TextColumn::make('min_quantity')
                    ->label('Min. Qty')
                    ->sortable(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
