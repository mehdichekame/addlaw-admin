<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GiftCodeResource\Pages;
use App\Filament\Resources\GiftCodeResource\RelationManagers;
use App\Models\GiftCode;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GiftCodeResource extends Resource
{
    protected static ?string $model = GiftCode::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'کدهای تخفیف';
    protected static ?string $pluralModelLabel = 'کد تخفیف';

    protected static ?string $navigationGroup = 'سایر';


    public static function getLabel(): ?string
    {
        return 'کدتخفیف';
    }

    public static function form(Form $form): Form
    {
        return $form

            ->schema([
                Forms\Components\Section::make('کدتخفیف')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('عنوان')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\DateTimePicker::make('started_at')
                            ->label('تاریخ شروع')
                            ->jalali()
                            ->required(),

                        Forms\Components\DateTimePicker::make('expired_at')
                            ->label('تاریخ پایان')
                            ->jalali()
                            ->required(),

                        Forms\Components\TextInput::make('total_count')
                            ->label('تعداد قابل استفاده')
                            ->numeric()
                            ->required(),

                        Forms\Components\TextInput::make('discount_percentage')
                            ->label('درصد تخفیف')
                            ->numeric()
                            ->suffix('%')
                            ->required(),

                        Forms\Components\TextInput::make('owner')
                            ->label('مالک')
                            ->maxLength(255),

                        Forms\Components\TagsInput::make('package_ids')
                            ->label('پکیج‌ها (ID ها)')
                            ->separator(','),

                        Select::make('user_ids')
                            ->label('کاربران مجاز')
                            ->multiple()
                            ->searchable()
                            ->options(User::query()->pluck('name', 'id'))
                            ->placeholder('جستجو بین کاربران...'),

                        Forms\Components\TextInput::make('code')
                            ->label('کد تخفیف')
                            ->unique(GiftCode::class, 'code', ignoreRecord: true)
                            ->default(fn () => strtoupper(str()->random(10)))
                            ->required(),

                        Forms\Components\TextInput::make('parent_id')
                            ->label('گیفت‌کد والد')
                            ->numeric()
                            ->nullable(),
                    ])
                ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('عنوان')
                    ->searchable(),

                Tables\Columns\TextColumn::make('code')
                    ->label('کد')
                    ->copyable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('discount_percentage')
                    ->label('تخفیف (%)')
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_count')
                    ->label('تعداد'),

                Tables\Columns\TextColumn::make('started_at')
                    ->label('شروع')
                    ->jalaliDate(),

                Tables\Columns\TextColumn::make('expired_at')
                    ->label('پایان')
                    ->jalaliDate(),

                Tables\Columns\TextColumn::make('owner')
                    ->label('مالک'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make()->label('ویرایش'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->label('حذف گروهی'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGiftCodes::route('/'),
            'create' => Pages\CreateGiftCode::route('/create'),
            'edit' => Pages\EditGiftCode::route('/{record}/edit'),
        ];
    }
}
