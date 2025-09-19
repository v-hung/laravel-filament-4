<?php

namespace App\Filament\Resources\Collections\Pages;

use App\Filament\Resources\Collections\CollectionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use LaraZeus\SpatieTranslatable\Resources\Pages\ViewRecord\Concerns\Translatable;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;

class ViewCollection extends ViewRecord
{
    use Translatable;

    protected static string $resource = CollectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            EditAction::make(),
        ];
    }
}
