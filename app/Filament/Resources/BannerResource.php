<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-photo';

    protected static string | \UnitEnum | null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Banner Content')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('title_en')
                                    ->label('Title (English)')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('title_ta')
                                    ->label('Title (Tamil)')
                                    ->maxLength(255),
                            ]),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('subtitle_en')
                                    ->label('Subtitle (English)')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('subtitle_ta')
                                    ->label('Subtitle (Tamil)')
                                    ->maxLength(255),
                            ]),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('button_text_en')
                                    ->label('Button Text (English)')
                                    ->maxLength(50),
                                Forms\Components\TextInput::make('button_text_ta')
                                    ->label('Button Text (Tamil)')
                                    ->maxLength(50),
                            ]),
                        Forms\Components\TextInput::make('link')
                            ->url()
                            ->maxLength(255)
                            ->prefix('/'),
                    ]),

                Forms\Components\Section::make('Images')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Desktop Image')
                            ->image()
                            ->directory('banners')
                            ->required()
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth('1920')
                            ->imageResizeTargetHeight('600'),

                        Forms\Components\FileUpload::make('mobile_image')
                            ->label('Mobile Image')
                            ->image()
                            ->directory('banners')
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth('768')
                            ->imageResizeTargetHeight('500'),
                    ]),

                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\Select::make('position')
                                    ->options([
                                        'hero' => 'Hero Slider',
                                        'promo' => 'Promotional',
                                        'sidebar' => 'Sidebar',
                                    ])
                                    ->default('hero'),
                                Forms\Components\TextInput::make('sort_order')
                                    ->numeric()
                                    ->default(0),
                                Forms\Components\Toggle::make('is_active')
                                    ->default(true),
                            ]),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\DateTimePicker::make('starts_at'),
                                Forms\Components\DateTimePicker::make('expires_at'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->width(120)
                    ->height(40),
                Tables\Columns\TextColumn::make('title_en')
                    ->label('Title')
                    ->searchable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('position')
                    ->badge(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('position')
                    ->options([
                        'hero' => 'Hero Slider',
                        'promo' => 'Promotional',
                        'sidebar' => 'Sidebar',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
