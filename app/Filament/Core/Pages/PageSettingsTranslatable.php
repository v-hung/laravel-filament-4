<?php

namespace App\Filament\Core\Pages;

use App\Filament\Core\Pages\HasPageTranslatable;
use App\Filament\Core\Pages\PageLocaleSwitcher;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use UnitEnum;

class PageSettingsTranslatable extends Page implements HasForms
{
    use InteractsWithForms, HasPageTranslatable;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected string $view = 'filament.pages.base-settings';

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    public function getTranslatableLocales(): array
    {
        return ['en', 'vi'];
    }

    protected function getHeaderActions(): array
    {
        return [
            PageLocaleSwitcher::make(),
            Action::make('save')
                ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
                ->action('save')
        ];
    }
}
