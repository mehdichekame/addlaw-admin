<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'کاربران';
    protected static ?string $pluralModelLabel = 'کاربران';
    protected static ?string $modelLabel = 'کاربر';
    protected static ?string $navigationGroup = 'مدیریت کاربران';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                ->schema([
                    Forms\Components\Section::make('اطلاعات عمومی')
                        ->schema([
                            TextInput::make('first_name')
                                ->label('نام')
                                ->required()
                                ->maxLength(50),

                            TextInput::make('last_name')
                                ->label('نام خانوادگی')
                                ->required()
                                ->maxLength(50),

                            TextInput::make('email')
                                ->label('ایمیل')
                                ->email()
                                ->unique(ignoreRecord: true),

                            TextInput::make('phone')
                                ->label('شماره موبایل')
                                ->tel()
                                ->unique(ignoreRecord: true),

                            Select::make('type')
                                ->label('نوع کاربر')
                                ->options([
                                    'user' => 'کاربر عادی',
                                    'admin' => 'مدیر',
                                    'seller' => 'فروشنده',
                                    'agent' => 'نماینده',
                                ])
                                ->native(false)
                                ->default('user')
                                ->required(),

                            Select::make('is_premium')
                                ->label('کاربر ویژه')
                                ->native(false)
                                ->options([
                                    'true' => 'بله',
                                    'false' => 'خیر',
                                ])
                                ->default('false'),
                        ])->columns(3),

                    Forms\Components\Section::make('امنیت')
                        ->schema([
                            DateTimePicker::make('email_verified_at')->label('تاریخ تأیید ایمیل'),
                            DateTimePicker::make('phone_verified_at')->label('تاریخ تأیید تلفن'),

                            TextInput::make('password')
                                ->password()
                                ->revealable()
                                ->label('رمز عبور')
                                ->dehydrateStateUsing(fn($state) => !empty($state) ? bcrypt($state) : null)
                                ->dehydrated(fn($state) => filled($state))
                                ->maxLength(255),
                        ])->columns(3),


                    Forms\Components\Section::make('اطلاعات اضافی')
                        ->schema([
                            Select::make('real_identity_id')
                                ->label('شناسه هویت واقعی')
                                ->relationship('realIdentity', 'id')
                                ->searchable(),

                            TagsInput::make('socials')
                                ->label('شبکه‌های اجتماعی')
                                ->placeholder('مثلاً: instagram.com/example'),
                        ])->columns(2),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')
                    ->label('نام')
                    ->formatStateUsing(fn($record) => $record->first_name . ' ' . $record->last_name)
                    ->sortable()
                    ->searchable(),

                TextColumn::make('email')
                    ->label('ایمیل')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('phone')
                    ->label('شماره')
                    ->searchable(),

                IconColumn::make('is_premium')
                    ->label('ویژه')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->color(fn($state) => $state ? 'warning' : 'gray'),

                TextColumn::make('type')
                    ->label('نوع')
                    ->badge()
                    ->colors([
                        'primary' => 'user',
                        'success' => 'admin',
                        'warning' => 'seller',
                        'info' => 'agent',
                    ])
                    ->formatStateUsing(fn($state) => match ($state) {
                        'admin' => 'مدیر',
                        'seller' => 'فروشنده',
                        'agent' => 'نماینده',
                        default => 'کاربر عادی'
                    }),

                IconColumn::make('email_verified_at')
                    ->label('ایمیل تایید')
                    ->boolean(),

                IconColumn::make('phone_verified_at')
                    ->label('تلفن تایید')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('عضویت')
                    ->date('Y-m-d')
                    ->sortable(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'view' => Pages\ViewUser::route('/{record}'), // مسیر View
        ];
    }
}
