<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Category;
use App\Models\Product;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationLabel = 'قراردادها';
    protected static ?string $pluralModelLabel = 'قرارداد';

    protected static ?string $navigationGroup = 'مدیریت قراردادها';

    public static function getLabel(): ?string
    {
        return 'قرارداد';
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Card::make([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->label('نام')
                        ->maxLength(256),
                    Forms\Components\Select::make('category_id')
                        ->label('دسته بندی')
                        ->options(Category::pluck('name', 'id'))
                        ->native(false)
                        ->required(),
                    Forms\Components\TextInput::make('price')
                        ->numeric()
                        ->label('قیمت')
                        ->required(),
                    Forms\Components\Select::make('currency')
                        ->label('واحد')
                        ->options(['IRR' => 'IRR'])
                        ->native(false)
                        ->required(),
                    Forms\Components\FileUpload::make('file')
                        ->label('فایل')
                        ->disk('public')
                        ->directory('products')
                        ->required(),
                    Forms\Components\FileUpload::make('image_url')
                        ->label('تصویر')
                        ->disk('public')
                        ->directory('products')
                        ->image()
                        ->required(),
                    Forms\Components\Textarea::make('description')
                        ->label('توضیحات')
                        ->required(),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('شناسه')->sortable(),
                Tables\Columns\TextColumn::make('name')->label('نام')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('دسته بندی'),

                Tables\Columns\TextColumn::make('price')
                ->label('قیمت'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ProductAttributesRelationManager::make(),
            RelationManagers\FaqsRelationManager::make()
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
