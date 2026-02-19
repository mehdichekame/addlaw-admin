<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationLabel = 'تیکت‌ها';
    protected static ?string $pluralLabel = 'تیکت‌ها';
    protected static ?string $navigationGroup = 'پشتیبانی';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('عنوان')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('description')
                    ->label('توضیحات')
                    ->rows(5)
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('department')
                    ->label('دپارتمان')
                    ->required(),

                Forms\Components\TextInput::make('service')
                    ->label('سرویس'),

                Forms\Components\TextInput::make('model_id')
                    ->label('شناسه مدل')
                    ->numeric(),

                Forms\Components\Select::make('status')
                    ->label('وضعیت')
                    ->options([
                        'open' => 'باز',
                        'pending' => 'در انتظار پاسخ',
                        'closed' => 'بسته',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('user_id')
                    ->label('شناسه کاربر')
                    ->numeric()
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

                TextColumn::make('title')
                    ->label('عنوان')
                    ->searchable()
                    ->limit(30),

                TextColumn::make('department')
                    ->label('دپارتمان')
                    ->sortable(),

                TextColumn::make('service')
                    ->label('سرویس'),

                TextColumn::make('status')
                    ->label('وضعیت')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'open' => 'success',
                        'pending' => 'warning',
                        'closed' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('وضعیت')
                    ->options([
                        'open' => 'باز',
                        'pending' => 'در انتظار پاسخ',
                        'closed' => 'بسته',
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
            // RelationManagers بعداً می‌تونیم اضافه کنیم (Messages, Attachments)
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
