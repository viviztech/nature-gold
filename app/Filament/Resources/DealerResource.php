<?php

namespace App\Filament\Resources;

use App\Enums\DealerStatus;
use App\Enums\TamilNaduDistrict;
use App\Enums\UserRole;
use App\Filament\Resources\DealerResource\Pages;
use App\Models\Dealer;
use App\Services\Notification\NotificationService;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DealerResource extends Resource
{
    protected static ?string $model = Dealer::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-building-storefront';

    protected static string | \UnitEnum | null $navigationGroup = 'Dealers';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'business_name';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Schemas\Components\Group::make()
                    ->schema([
                        Schemas\Components\Section::make('Business Information')
                            ->schema([
                                Forms\Components\TextInput::make('business_name')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\Select::make('user_id')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Forms\Components\TextInput::make('gst_number')
                                    ->label('GST Number')
                                    ->maxLength(15),

                                Forms\Components\Select::make('business_type')
                                    ->options([
                                        'retail' => 'Retail',
                                        'wholesale' => 'Wholesale',
                                        'distributor' => 'Distributor',
                                    ])
                                    ->required(),

                                Forms\Components\Select::make('territory')
                                    ->label('Territory (District)')
                                    ->options(collect(TamilNaduDistrict::cases())->mapWithKeys(fn ($d) => [$d->value => $d->label()]))
                                    ->searchable(),

                                Forms\Components\Textarea::make('business_address')
                                    ->rows(3),
                            ]),

                        Schemas\Components\Section::make('Documents')
                            ->schema([
                                Forms\Components\FileUpload::make('gst_certificate')
                                    ->label('GST Certificate')
                                    ->directory('dealers/documents')
                                    ->acceptedFileTypes(['application/pdf', 'image/*']),

                                Forms\Components\FileUpload::make('trade_license')
                                    ->label('Trade License')
                                    ->directory('dealers/documents')
                                    ->acceptedFileTypes(['application/pdf', 'image/*']),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                Schemas\Components\Group::make()
                    ->schema([
                        Schemas\Components\Section::make('Status & Commission')
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->options(collect(DealerStatus::cases())->mapWithKeys(fn ($s) => [$s->value => $s->label()]))
                                    ->required()
                                    ->default('pending'),

                                Forms\Components\TextInput::make('commission_rate')
                                    ->label('Commission Rate (%)')
                                    ->numeric()
                                    ->suffix('%')
                                    ->default(0),

                                Forms\Components\Textarea::make('rejection_reason')
                                    ->label('Rejection Reason')
                                    ->rows(3)
                                    ->visible(fn (Schemas\Components\Utilities\Get $get) => $get('status') === 'rejected'),

                                Forms\Components\Placeholder::make('approved_at_display')
                                    ->label('Approved At')
                                    ->content(fn (?Dealer $record) => $record?->approved_at?->format('d M Y, h:i A') ?? 'Not approved')
                                    ->visibleOn('edit'),
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
                Tables\Columns\TextColumn::make('business_name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Owner')
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.phone')
                    ->label('Phone'),

                Tables\Columns\TextColumn::make('business_type')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => ucfirst($state)),

                Tables\Columns\TextColumn::make('territory')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('gst_number')
                    ->label('GST')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (DealerStatus $state) => $state->color()),

                Tables\Columns\TextColumn::make('commission_rate')
                    ->suffix('%')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Applied')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(collect(DealerStatus::cases())->mapWithKeys(fn ($s) => [$s->value => $s->label()])),

                Tables\Filters\SelectFilter::make('business_type')
                    ->options([
                        'retail' => 'Retail',
                        'wholesale' => 'Wholesale',
                        'distributor' => 'Distributor',
                    ]),

                Tables\Filters\SelectFilter::make('territory')
                    ->options(collect(TamilNaduDistrict::cases())->mapWithKeys(fn ($d) => [$d->value => $d->label()])),
            ])
            ->actions([
                Actions\Action::make('approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Dealer $record) => $record->isPending())
                    ->action(function (Dealer $record) {
                        $record->update([
                            'status' => DealerStatus::Approved,
                            'approved_at' => now(),
                        ]);

                        // Ensure user has dealer role
                        if ($record->user && $record->user->role !== UserRole::Dealer) {
                            $record->user->update(['role' => UserRole::Dealer]);
                        }

                        Notification::make()
                            ->title('Dealer approved successfully')
                            ->success()
                            ->send();

                        // Send WhatsApp + Email notification to dealer
                        app(NotificationService::class)->dealerApproved($record);
                    }),

                Actions\Action::make('reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (Dealer $record) => $record->isPending())
                    ->form([
                        Forms\Components\Textarea::make('rejection_reason')
                            ->required()
                            ->rows(3),
                    ])
                    ->action(function (Dealer $record, array $data) {
                        $record->update([
                            'status' => DealerStatus::Rejected,
                            'rejection_reason' => $data['rejection_reason'],
                        ]);

                        Notification::make()
                            ->title('Dealer application rejected')
                            ->warning()
                            ->send();

                        // Send WhatsApp + Email notification to dealer
                        app(NotificationService::class)->dealerRejected($record);
                    }),

                Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            DealerResource\RelationManagers\SpecialPricingRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDealers::route('/'),
            'create' => Pages\CreateDealer::route('/create'),
            'edit' => Pages\EditDealer::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', DealerStatus::Pending)->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
}
