<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Infolists;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-shopping-cart';

    protected static string | \UnitEnum | null $navigationGroup = 'Orders';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'order_number';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Order Details')
                            ->schema([
                                Forms\Components\TextInput::make('order_number')
                                    ->disabled(),

                                Forms\Components\Select::make('status')
                                    ->options(collect(OrderStatus::cases())->mapWithKeys(fn ($s) => [$s->value => $s->label()]))
                                    ->required(),

                                Forms\Components\Select::make('payment_status')
                                    ->options(collect(PaymentStatus::cases())->mapWithKeys(fn ($s) => [$s->value => $s->label()]))
                                    ->required(),

                                Forms\Components\Textarea::make('admin_notes')
                                    ->rows(3),
                            ]),

                        Forms\Components\Section::make('Shipping')
                            ->schema([
                                Forms\Components\TextInput::make('tracking_number'),
                                Forms\Components\TextInput::make('tracking_url')
                                    ->url(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Summary')
                            ->schema([
                                Forms\Components\Placeholder::make('user')
                                    ->content(fn (Order $record) => $record->user?->name ?? 'Guest'),

                                Forms\Components\Placeholder::make('total_display')
                                    ->label('Total')
                                    ->content(fn (Order $record) => '₹' . number_format($record->total, 2)),

                                Forms\Components\Placeholder::make('payment_method_display')
                                    ->label('Payment Method')
                                    ->content(fn (Order $record) => $record->payment_method?->label() ?? '-'),

                                Forms\Components\Placeholder::make('created')
                                    ->label('Order Date')
                                    ->content(fn (Order $record) => $record->created_at->format('d M Y, h:i A')),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function infolist(Schema $infolist): Schema
    {
        return $infolist
            ->schema([
                Infolists\Components\Group::make()
                    ->schema([
                        Infolists\Components\Section::make('Order Information')
                            ->schema([
                                Infolists\Components\TextEntry::make('order_number')
                                    ->label('Order #')
                                    ->weight('bold')
                                    ->size('lg'),

                                Infolists\Components\TextEntry::make('status')
                                    ->badge()
                                    ->color(fn (OrderStatus $state) => $state->color()),

                                Infolists\Components\TextEntry::make('payment_status')
                                    ->badge()
                                    ->color(fn (PaymentStatus $state) => $state->color()),

                                Infolists\Components\TextEntry::make('payment_method')
                                    ->formatStateUsing(fn ($state) => $state?->label() ?? '-'),

                                Infolists\Components\TextEntry::make('created_at')
                                    ->label('Order Date')
                                    ->dateTime('d M Y, h:i A'),

                                Infolists\Components\TextEntry::make('is_dealer_order')
                                    ->label('Dealer Order')
                                    ->badge()
                                    ->formatStateUsing(fn (bool $state) => $state ? 'Yes' : 'No')
                                    ->color(fn (bool $state) => $state ? 'info' : 'gray'),
                            ])
                            ->columns(3),

                        Infolists\Components\Section::make('Order Items')
                            ->schema([
                                Infolists\Components\RepeatableEntry::make('items')
                                    ->schema([
                                        Infolists\Components\TextEntry::make('product_name')
                                            ->label('Product'),
                                        Infolists\Components\TextEntry::make('variant_name')
                                            ->label('Variant')
                                            ->placeholder('-'),
                                        Infolists\Components\TextEntry::make('quantity'),
                                        Infolists\Components\TextEntry::make('unit_price')
                                            ->money('INR'),
                                        Infolists\Components\TextEntry::make('total')
                                            ->money('INR')
                                            ->weight('bold'),
                                    ])
                                    ->columns(5),
                            ]),

                        Infolists\Components\Section::make('Shipping Address')
                            ->schema([
                                Infolists\Components\TextEntry::make('shipping_address')
                                    ->formatStateUsing(function ($state) {
                                        if (! is_array($state)) {
                                            return '-';
                                        }

                                        return implode(', ', array_filter([
                                            $state['name'] ?? '',
                                            $state['line1'] ?? '',
                                            $state['line2'] ?? '',
                                            $state['city'] ?? '',
                                            $state['district'] ?? '',
                                            $state['state'] ?? '',
                                            $state['pincode'] ?? '',
                                        ]));
                                    }),
                                Infolists\Components\TextEntry::make('shipping_address.phone')
                                    ->label('Phone')
                                    ->getStateUsing(fn (Order $record) => $record->shipping_address['phone'] ?? '-'),
                            ])
                            ->columns(2),

                        Infolists\Components\Section::make('Tracking')
                            ->schema([
                                Infolists\Components\TextEntry::make('tracking_number')
                                    ->placeholder('Not available'),
                                Infolists\Components\TextEntry::make('tracking_url')
                                    ->url(fn ($state) => $state)
                                    ->placeholder('Not available'),
                            ])
                            ->columns(2)
                            ->collapsed(),
                    ])
                    ->columnSpan(['lg' => 2]),

                Infolists\Components\Group::make()
                    ->schema([
                        Infolists\Components\Section::make('Customer')
                            ->schema([
                                Infolists\Components\TextEntry::make('user.name')
                                    ->label('Name'),
                                Infolists\Components\TextEntry::make('user.email')
                                    ->label('Email'),
                                Infolists\Components\TextEntry::make('user.phone')
                                    ->label('Phone'),
                            ]),

                        Infolists\Components\Section::make('Order Summary')
                            ->schema([
                                Infolists\Components\TextEntry::make('subtotal')
                                    ->money('INR'),
                                Infolists\Components\TextEntry::make('discount')
                                    ->money('INR')
                                    ->visible(fn ($state) => $state > 0),
                                Infolists\Components\TextEntry::make('shipping_cost')
                                    ->label('Shipping')
                                    ->money('INR'),
                                Infolists\Components\TextEntry::make('tax')
                                    ->label('GST')
                                    ->money('INR'),
                                Infolists\Components\TextEntry::make('total')
                                    ->money('INR')
                                    ->weight('bold')
                                    ->size('lg'),
                            ]),

                        Infolists\Components\Section::make('Timeline')
                            ->schema([
                                Infolists\Components\TextEntry::make('confirmed_at')
                                    ->dateTime('d M Y, h:i A')
                                    ->placeholder('Not yet'),
                                Infolists\Components\TextEntry::make('shipped_at')
                                    ->dateTime('d M Y, h:i A')
                                    ->placeholder('Not yet'),
                                Infolists\Components\TextEntry::make('delivered_at')
                                    ->dateTime('d M Y, h:i A')
                                    ->placeholder('Not yet'),
                                Infolists\Components\TextEntry::make('cancelled_at')
                                    ->dateTime('d M Y, h:i A')
                                    ->placeholder('-')
                                    ->visible(fn ($state) => filled($state)),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('Order #')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('items_count')
                    ->label('Items')
                    ->counts('items'),

                Tables\Columns\TextColumn::make('total')
                    ->money('INR')
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (OrderStatus $state) => $state->color()),

                Tables\Columns\TextColumn::make('payment_status')
                    ->badge()
                    ->color(fn (PaymentStatus $state) => $state->color()),

                Tables\Columns\TextColumn::make('payment_method')
                    ->formatStateUsing(fn ($state) => $state?->label() ?? '-')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make('is_dealer_order')
                    ->label('Dealer')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(collect(OrderStatus::cases())->mapWithKeys(fn ($s) => [$s->value => $s->label()])),

                Tables\Filters\SelectFilter::make('payment_status')
                    ->options(collect(PaymentStatus::cases())->mapWithKeys(fn ($s) => [$s->value => $s->label()])),

                Tables\Filters\TernaryFilter::make('is_dealer_order')
                    ->label('Dealer Order'),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('from'),
                        Forms\Components\DatePicker::make('until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q, $date) => $q->whereDate('created_at', '>=', $date))
                            ->when($data['until'], fn ($q, $date) => $q->whereDate('created_at', '<=', $date));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', OrderStatus::Pending)->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
}
