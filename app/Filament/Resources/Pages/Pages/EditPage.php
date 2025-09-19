<?php

namespace App\Filament\Resources\Pages\Pages;

use App\Filament\Core\Resources\EditTranslatable;
use App\Filament\Resources\Pages\PageResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;

class EditPage extends EditRecord
{
    use EditTranslatable;

    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
