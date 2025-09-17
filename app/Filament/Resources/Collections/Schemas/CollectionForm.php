<?php

namespace App\Filament\Resources\Collections\Schemas;

use App\Enums\CategoryStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CollectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('description'),
                Select::make('status')
                    ->options(CategoryStatus::class),
            ]);
    }
}
