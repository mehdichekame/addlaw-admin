<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MessageResource\Pages;
use App\Models\Message;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class MessageResource extends Resource
{
    protected static ?string $model = Message::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'پیام‌ها';
    protected static ?string $pluralLabel = 'پیام‌ها';
    protected static ?string $navigationGroup = 'پشتیبانی';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('content')
                    ->label('متن پیام')
                    ->required()
                    ->rows(5)
                    ->columnSpanFull(),

                Forms\Components\Select::make('from')
                    ->label('ارسال‌کننده')
                    ->options([
                        'user' => 'کاربر',
                        'admin' => 'ادمین',
                    ])
                    ->required(),

                Forms\Components\Select::make('ticket_id')
                    ->label('تیکت')
                    ->relationship('ticket', 'title')
                    ->searchable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->sortable(),

                TextColumn::make('ticket.title')
                    ->label('تیکت')
                    ->limit(30)
                    ->searchable(),

                TextColumn::make('content')
                    ->label('پیام')
                    ->limit(50),

                TextColumn::make('from')
                    ->label('ارسال‌کننده')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'admin' => 'info',
                        'user' => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label('تاریخ')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('from')
                    ->label('ارسال‌کننده')
                    ->options([
                        'user' => 'کاربر',
                        'admin' => 'ادمین',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // AttachmentRelationManager رو می‌تونیم اینجا اضافه کنیم
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMessages::route('/'),
            'create' => Pages\CreateMessage::route('/create'),
            'edit' => Pages\EditMessage::route('/{record}/edit'),
        ];
    }
}
