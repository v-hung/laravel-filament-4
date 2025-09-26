<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Core\Resources\EditTranslatable;
use App\Filament\Forms\Components\HasProductOptionVariant;
use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;

class EditProduct extends EditRecord
{
    use EditTranslatable, HasProductOptionVariant;

    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
