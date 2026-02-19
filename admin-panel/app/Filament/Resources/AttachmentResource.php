<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttachmentResource\Pages;
use App\Models\Attachment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class AttachmentResource extends Resource
{
    protected static ?string $model = Attachment::class;

    protected static ?string $navigationIcon = 'heroicon-o-paper-clip';
    protected static ?string $navigationLabel = 'پیوست‌ها';
    protected static ?string $pluralLabel = 'پیوست‌ها';
    protected static ?string $navigationGroup = 'پشتیبانی';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('file')
                    ->label('فایل')
                    ->directory('attachments')
                    ->downloadable()
                    ->openable()
                    ->required(),

                Forms\Components\TextInput::make('original_file_name')
                    ->label('نام فایل اصلی')
                    ->disabled(),

                Forms\Components\Select::make('message_id')
                    ->label('پیام')
                    ->relationship('message', 'id')
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

                TextColumn::make('original_file_name')
                    ->label('نام فایل'),

                TextColumn::make('file')
                    ->label('مسیر فایل')
                    ->copyable()
                    ->limit(40),

                TextColumn::make('message.id')
                    ->label('شناسه پیام'),

                TextColumn::make('created_at')
                    ->label('تاریخ')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttachments::route('/'),
            'create' => Pages\CreateAttachment::route('/create'),
            'edit' => Pages\EditAttachment::route('/{record}/edit'),
        ];
    }
}
