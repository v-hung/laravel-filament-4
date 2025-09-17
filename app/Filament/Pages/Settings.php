<?php

namespace App\Filament\Pages;

use App\Filament\Core\Pages\PageSettingsTranslatable;
use App\Helpers\Filament\FormHelper;
use BackedEnum;
use Filament\Schemas\Schema;

class Settings extends PageSettingsTranslatable
{
    public static string $GROUP_KEY = 'shop';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $title = 'Shop Settings';

    public array $translatableAttributes = ['site_name'];

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\TextInput::make('site_name')->label(FormHelper::localizedLabel("Site Name")),
                \Filament\Forms\Components\TextInput::make('site_logo')->label(FormHelper::localizedLabel("Site Logo")),
                \Filament\Forms\Components\TextArea::make('site_description')->label(FormHelper::localizedLabel("Site Description"))
            ])->statePath('data');
    }
}
