<?php

namespace App\Filament\Resources;

use App\Enums\TamilNaduDistrict;
use App\Filament\Resources\ShippingZoneResource\Pages;
use App\Models\ShippingZone;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ShippingZoneResource extends Resource
{
    protected static ?string $model = ShippingZone::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-truck';

    protected static string | \UnitEnum | null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Schemas\Components\Section::make('Zone Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('districts')
                            ->multiple()
                            ->options(collect(TamilNaduDistrict::cases())->mapWithKeys(fn ($d) => [$d->value => $d->label()]))
                            ->searchable()
                            ->required(),

                        Schemas\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('base_rate')
                                    ->label('Base Rate')
                                    ->numeric()
                                    ->required()
                                    ->prefix('₹'),
                                Forms\Components\TextInput::make('per_kg_rate')
                                    ->label('Per KG Rate')
                                    ->numeric()
                                    ->default(0)
                                    ->prefix('₹'),
                                Forms\Components\TextInput::make('free_above')
                                    ->label('Free Shipping Above')
                                    ->numeric()
                                    ->prefix('₹'),
                            ]),

                        Schemas\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('estimated_days')
                                    ->placeholder('e.g., 2-3 days'),
                                Forms\Components\Toggle::make('is_active')
                                    ->default(true),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('districts')
                    ->formatStateUsing(fn (array $state) => count($state) . ' districts')
                    ->badge(),
                Tables\Columns\TextColumn::make('base_rate')->money('INR'),
                Tables\Columns\TextColumn::make('free_above')->money('INR')->placeholder('-'),
                Tables\Columns\TextColumn::make('estimated_days')->placeholder('-'),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShippingZones::route('/'),
            'create' => Pages\CreateShippingZone::route('/create'),
            'edit' => Pages\EditShippingZone::route('/{record}/edit'),
        ];
    }
}
