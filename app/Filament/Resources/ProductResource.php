<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-shopping-bag';

    protected static string | \UnitEnum | null $navigationGroup = 'Shop';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name_en';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Schemas\Components\Group::make()
                    ->schema([
                        Schemas\Components\Section::make('Product Information')
                            ->schema([
                                Schemas\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('name_en')
                                            ->label('Name (English)')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (Schemas\Components\Utilities\Set $set, ?string $state) => $set('slug', Str::slug($state))),

                                        Forms\Components\TextInput::make('name_ta')
                                            ->label('Name (Tamil)')
                                            ->maxLength(255),
                                    ]),

                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),

                                Schemas\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\RichEditor::make('description_en')
                                            ->label('Description (English)')
                                            ->columnSpanFull(),

                                        Forms\Components\RichEditor::make('description_ta')
                                            ->label('Description (Tamil)')
                                            ->columnSpanFull(),
                                    ]),

                                Schemas\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\Textarea::make('short_description_en')
                                            ->label('Short Description (English)')
                                            ->rows(2),

                                        Forms\Components\Textarea::make('short_description_ta')
                                            ->label('Short Description (Tamil)')
                                            ->rows(2),
                                    ]),
                            ]),

                        Schemas\Components\Section::make('Images')
                            ->schema([
                                Forms\Components\Repeater::make('images')
                                    ->relationship()
                                    ->schema([
                                        Forms\Components\FileUpload::make('image_path')
                                            ->label('Image')
                                            ->image()
                                            ->disk('public')
                                            ->directory('products')
                                            ->required()
                                            ->imageResizeMode('cover')
                                            ->imageResizeTargetWidth('800')
                                            ->imageResizeTargetHeight('800'),

                                        Forms\Components\TextInput::make('alt_text')
                                            ->label('Alt Text')
                                            ->maxLength(255),

                                        Forms\Components\Toggle::make('is_primary')
                                            ->label('Primary Image'),
                                    ])
                                    ->columns(3)
                                    ->reorderable('sort_order')
                                    ->defaultItems(0)
                                    ->collapsible()
                                    ->cloneable(),
                            ]),

                        Schemas\Components\Section::make('Variants')
                            ->schema([
                                Forms\Components\Repeater::make('variants')
                                    ->relationship()
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Variant Name')
                                            ->required()
                                            ->placeholder('e.g., 200ml, 500ml, 1 Litre'),

                                        Forms\Components\TextInput::make('sku')
                                            ->label('SKU')
                                            ->unique(ignoreRecord: true),

                                        Forms\Components\TextInput::make('price')
                                            ->numeric()
                                            ->required()
                                            ->prefix('₹'),

                                        Forms\Components\TextInput::make('sale_price')
                                            ->numeric()
                                            ->prefix('₹'),

                                        Forms\Components\TextInput::make('stock')
                                            ->numeric()
                                            ->required()
                                            ->default(0),

                                        Forms\Components\TextInput::make('weight')
                                            ->placeholder('e.g., 200ml'),

                                        Forms\Components\Toggle::make('is_active')
                                            ->default(true),
                                    ])
                                    ->columns(4)
                                    ->reorderable('sort_order')
                                    ->defaultItems(0)
                                    ->collapsible()
                                    ->cloneable()
                                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? null),
                            ]),

                        Schemas\Components\Section::make('Nutritional Information')
                            ->collapsed()
                            ->schema([
                                Forms\Components\RichEditor::make('nutritional_info_en')
                                    ->label('Nutritional Info (English)'),

                                Forms\Components\RichEditor::make('nutritional_info_ta')
                                    ->label('Nutritional Info (Tamil)'),
                            ]),

                        Schemas\Components\Section::make('SEO')
                            ->collapsed()
                            ->schema([
                                Forms\Components\TextInput::make('meta_title')
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('meta_description')
                                    ->rows(2),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                Schemas\Components\Group::make()
                    ->schema([
                        Schemas\Components\Section::make('Pricing')
                            ->schema([
                                Forms\Components\TextInput::make('price')
                                    ->numeric()
                                    ->required()
                                    ->prefix('₹')
                                    ->step(0.01),

                                Forms\Components\TextInput::make('sale_price')
                                    ->numeric()
                                    ->prefix('₹')
                                    ->step(0.01)
                                    ->lte('price'),

                                Forms\Components\TextInput::make('tax_rate')
                                    ->label('GST Rate (%)')
                                    ->numeric()
                                    ->default(5)
                                    ->suffix('%'),
                            ]),

                        Schemas\Components\Section::make('Inventory')
                            ->schema([
                                Forms\Components\TextInput::make('sku')
                                    ->label('SKU')
                                    ->unique(ignoreRecord: true),

                                Forms\Components\TextInput::make('stock')
                                    ->numeric()
                                    ->required()
                                    ->default(0),

                                Forms\Components\TextInput::make('weight')
                                    ->placeholder('e.g., 1kg'),

                                Forms\Components\Select::make('unit')
                                    ->options([
                                        'piece' => 'Piece',
                                        'kg' => 'Kilogram',
                                        'gm' => 'Gram',
                                        'ltr' => 'Litre',
                                        'ml' => 'Millilitre',
                                    ])
                                    ->default('piece'),
                            ]),

                        Schemas\Components\Section::make('Organization')
                            ->schema([
                                Forms\Components\Select::make('category_id')
                                    ->relationship('category', 'name_en')
                                    ->searchable()
                                    ->preload(),

                                Forms\Components\Toggle::make('is_active')
                                    ->label('Active')
                                    ->default(true),

                                Forms\Components\Toggle::make('is_featured')
                                    ->label('Featured'),

                                Forms\Components\Toggle::make('is_bestseller')
                                    ->label('Bestseller'),

                                Forms\Components\TextInput::make('sort_order')
                                    ->numeric()
                                    ->default(0),
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
                Tables\Columns\TextColumn::make('name_en')
                    ->label('Product')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('category.name_en')
                    ->label('Category')
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->money('INR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('sale_price')
                    ->money('INR')
                    ->sortable()
                    ->placeholder('-')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('stock')
                    ->sortable()
                    ->color(fn (int $state): string => $state <= 10 ? 'danger' : ($state <= 50 ? 'warning' : 'success'))
                    ->badge(),

                Tables\Columns\TextColumn::make('variants_count')
                    ->label('Variants')
                    ->counts('variants')
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->relationship('category', 'name_en')
                    ->label('Category')
                    ->preload(),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active'),

                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured'),

                Tables\Filters\TernaryFilter::make('is_bestseller')
                    ->label('Bestseller'),

                Tables\Filters\Filter::make('low_stock')
                    ->label('Low Stock (≤10)')
                    ->query(fn ($query) => $query->where('stock', '<=', 10)),
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

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('stock', '<=', 10)->where('is_active', true)->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Low stock products';
    }
}
