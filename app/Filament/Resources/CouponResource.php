<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CouponResource\Pages;
use App\Models\Coupon;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-ticket';

    protected static string | \UnitEnum | null $navigationGroup = 'Shop';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Coupon Details')
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50)
                            ->formatStateUsing(fn (?string $state) => strtoupper($state ?? ''))
                            ->dehydrateStateUsing(fn (string $state) => strtoupper($state)),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('type')
                                    ->options([
                                        'percentage' => 'Percentage (%)',
                                        'fixed' => 'Fixed Amount (₹)',
                                    ])
                                    ->required()
                                    ->default('percentage'),

                                Forms\Components\TextInput::make('value')
                                    ->numeric()
                                    ->required()
                                    ->step(0.01),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('min_order')
                                    ->label('Minimum Order Amount')
                                    ->numeric()
                                    ->prefix('₹'),

                                Forms\Components\TextInput::make('max_discount')
                                    ->label('Maximum Discount')
                                    ->numeric()
                                    ->prefix('₹'),
                            ]),

                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('usage_limit')
                                    ->label('Total Usage Limit')
                                    ->numeric()
                                    ->placeholder('Unlimited'),

                                Forms\Components\TextInput::make('per_user_limit')
                                    ->label('Per User Limit')
                                    ->numeric()
                                    ->default(1),

                                Forms\Components\Placeholder::make('used_count_display')
                                    ->label('Times Used')
                                    ->content(fn (?Coupon $record) => $record?->used_count ?? 0)
                                    ->visibleOn('edit'),
                            ]),
                    ]),

                Forms\Components\Section::make('Validity')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\DateTimePicker::make('starts_at'),
                                Forms\Components\DateTimePicker::make('expires_at'),
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
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable(),

                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => $state === 'percentage' ? 'Percentage' : 'Fixed'),

                Tables\Columns\TextColumn::make('value')
                    ->formatStateUsing(fn (Coupon $record) => $record->type === 'percentage' ? "{$record->value}%" : "₹{$record->value}"),

                Tables\Columns\TextColumn::make('min_order')
                    ->money('INR')
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('used_count')
                    ->label('Used')
                    ->formatStateUsing(fn (Coupon $record) => $record->usage_limit ? "{$record->used_count}/{$record->usage_limit}" : $record->used_count),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),

                Tables\Columns\TextColumn::make('expires_at')
                    ->dateTime('d M Y')
                    ->placeholder('No expiry')
                    ->color(fn (?string $state) => $state && now()->gt($state) ? 'danger' : null),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }
}
