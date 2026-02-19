<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use App\Models\Attribute;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\RelationManagers\RelationManager;

class ProductAttributesRelationManager extends RelationManager
{
    protected static string $relationship = 'productAttributes';
    protected static ?string $title = 'Product Attributes';

    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\Select::make('attribute_id')
                ->label('Attribute')
                ->searchable()
                ->options(Attribute::pluck('name', 'id'))
                ->required(),
            Forms\Components\TextInput::make('value')->label('Value')->required(),
        ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('attribute.name')->label('Attribute'),
                Tables\Columns\TextColumn::make('value')->label('مقدار'),
            ])
            ->headerActions([Tables\Actions\CreateAction::make()->label('افزودن Product Attribute')])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
