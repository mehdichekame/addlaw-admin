<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\RelationManagers\RelationManager;

class FaqsRelationManager extends RelationManager
{
    protected static string $relationship = 'faqs';
    protected static ?string $title = 'FAQs';

    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\Textarea::make('question')->label('سوال')->required(),
            Forms\Components\Textarea::make('answer')->label('پاسخ')->required(),
        ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('question')
                ->label('سوال'),
                Tables\Columns\TextColumn::make('answer')
                    ->label('پاسخ')
                    ->limit(50),
            ])
            ->headerActions([Tables\Actions\CreateAction::make()->label('افزودن FAQ')])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
