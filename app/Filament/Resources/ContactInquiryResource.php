<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactInquiryResource\Pages;
use App\Models\ContactInquiry;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactInquiryResource extends Resource
{
    protected static ?string $model = ContactInquiry::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-envelope';

    protected static string | \UnitEnum | null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationLabel = 'Inquiries';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Schemas\Components\Section::make('Inquiry Details')
                    ->schema([
                        Schemas\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('name')->disabled(),
                                Forms\Components\TextInput::make('email')->disabled(),
                                Forms\Components\TextInput::make('phone')->disabled(),
                            ]),
                        Forms\Components\TextInput::make('subject')->disabled(),
                        Forms\Components\Textarea::make('message')->disabled()->rows(4),
                        Forms\Components\TextInput::make('type')->disabled(),
                    ]),
                Schemas\Components\Section::make('Admin Response')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options(['new' => 'New', 'read' => 'Read', 'replied' => 'Replied'])
                            ->required(),
                        Forms\Components\Textarea::make('admin_reply')
                            ->rows(4),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'dealer' => 'warning',
                        'bulk' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'new' => 'warning',
                        'read' => 'info',
                        'replied' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y')->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(['new' => 'New', 'read' => 'Read', 'replied' => 'Replied']),
                Tables\Filters\SelectFilter::make('type')
                    ->options(['general' => 'General', 'dealer' => 'Dealer', 'bulk' => 'Bulk Order']),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactInquiries::route('/'),
            'edit' => Pages\EditContactInquiry::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'new')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
}
