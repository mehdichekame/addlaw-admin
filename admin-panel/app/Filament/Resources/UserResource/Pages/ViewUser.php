<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected static string $view = 'filament.resources.user-resource.pages.view-user';

    public function infolist(Infolist $infolist): Infolist
    {
        return Infolist::make()
            ->schema([
                Section::make('اطلاعات عمومی')
                    ->schema([
                        TextEntry::make('first_name')->label('نام'),
                        TextEntry::make('last_name')->label('نام خانوادگی'),
                        TextEntry::make('email')->label('ایمیل'),
                        TextEntry::make('phone')->label('شماره موبایل'),
                    ]),
                Section::make('امنیت')
                    ->schema([
                        TextEntry::make('email_verified_at')->label('تاریخ تأیید ایمیل'),
                        TextEntry::make('phone_verified_at')->label('تاریخ تأیید تلفن'),
                        // رمز عبور نمایش داده نمی‌شود
                    ]),
            ]);
    }


}
